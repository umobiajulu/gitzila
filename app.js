const http = require('http');
const url = require('url');
const { Client } = require('ssh2');
const { readFileSync } = require('fs');
const { exec } = require('child_process');
const FtpClient = require('ssh2-sftp-client');

const server = http.createServer((req, res) => {
    var check = url.parse(req.url,true).query.check
    var host = url.parse(req.url,true).query.host
    var name = url.parse(req.url,true).query.name
    var email = url.parse(req.url,true).query.email
    var unique_id = url.parse(req.url,true).query.unique_id
    var git_url = url.parse(req.url,true).query.git_url
    var nickname = url.parse(req.url,true).query.nickname
    var repo_name = url.parse(req.url,true).query.repo_name
    var server_root = url.parse(req.url,true).query.server_root
    var server_connection = url.parse(req.url,true).query.server_connection
    var server_address = url.parse(req.url,true).query.server_address
    var server_username = url.parse(req.url,true).query.server_username
    var server_password = url.parse(req.url,true).query.server_password
    var server_port = url.parse(req.url,true).query.server_port
    var configuration_commands = url.parse(req.url,true).query.configuration_commands
    var deployment_commands = url.parse(req.url,true).query.deployment_commands
  	res.statusCode = 200;
  	res.setHeader('Content-Type', 'text/plain');

	function dispatch(file) {
	    const client = new FtpClient()
 		const config = {
            host: server_address,
            username: server_username,
            password: server_password,
            port: server_port
 		}
		client.connect(config)
			.then(() => {
				console.log('about to deploy')
				return client.put('./storage/users/' + unique_id + '/ftp/' + repo_name + '/' + file, server_root + '/' + file);
			})
			.then(() => {
				console.log('deployment completed')
				return client.end();
			})
			.catch(err => {
				console.error(err.message);
			});
	}

  	try{
		if(check == 'ssh'){
			var ssh_destination_folder = '/var/www/gitzila/storage/users/'+ unique_id +'/ssh'
			var ftp_destination_folder = '/var/www/gitzila/storage/users/'+ unique_id +'/ftp'
			exec('rm '+ ssh_destination_folder +' -rf && mkdir ' + ssh_destination_folder + ' && ssh-keygen -f ' + ssh_destination_folder + '/id_rsa -q -N "" && cd ' + ssh_destination_folder + ' && touch authorized_keys && cp id_rsa.pub authorized_keys && zip -r '+ host +'_keys.zip id_rsa id_rsa.pub authorized_keys && mkdir -p ' + ftp_destination_folder + ' && cp ' + ssh_destination_folder + '/id_rsa ' + ftp_destination_folder + '/id_rsa && chmod 400 ' + ftp_destination_folder + '/id_rsa');
		}
		else{
			if(server_connection == 'ssh'){
				const conn = new Client();
				conn.on('ready', (req) => {
					if(check == 'configure'){
						conn.exec('cd '+ server_root +' && rm .git -rf && git init && git config user.email "'+ email +'" && git config user.name "'+ name +'" && git add . && git commit -am "initial commit" && git remote add gitzila '+ git_url +' && git fetch gitzila && git checkout gitzila/master && ' + configuration_commands.replace(",", " && ") , (err, stream) => {
							if (err) throw err;
								stream.on('close', (code, signal) => {
								conn.end();
							}).on('data', (data) => {
								console.log('STDOUT: ' + data);
							}).stderr.on('data', (data) => {
								console.log('STDERR: ' + data);
							});
						});
					}
					if(check == 'deploy'){
						conn.exec('cd '+ server_root +' && git pull gitzila master --allow-unrelated-histories && ' + deployment_commands.replace(",", " && "), (err, stream) => {
							if (err) throw err;
								stream.on('close', (code, signal) => {
								conn.end();
							}).on('data', (data) => {
								console.log('STDOUT: ' + data);
							}).stderr.on('data', (data) => {
								console.log('STDERR: ' + data);
							});
						});
					}
				}).connect({
					host: server_address,
					port: server_port,
					username: server_username,
					privateKey: readFileSync('./storage/users/'+ unique_id +'/id_rsa')
				});
			}
			else{
				if(check == 'configure'){
					var folder = '/var/www/gitzila/storage/users/'+ unique_id +'/ftp'
					var destination_folder = '/var/www/gitzila/storage/users/'+ unique_id +'/ftp/' + repo_name
					exec('rm ' + destination_folder + ' -rf && cd '+ folder +' && ssh-agent bash -c "ssh-add '+ folder +'/id_rsa; git clone ' + git_url +'"', (error, stdout, stderr) => {
						if (error) {
							console.error(`exec error: ${error}`);
							return;
						}
						console.log(`stdout: ${stdout}`);
						console.error(`stderr: ${stderr}`);
					});
				}
				else{
					var folder = '/var/www/gitzila/storage/users/'+ unique_id +'/ftp'
					var destination_folder = '/var/www/gitzila/storage/users/'+ unique_id +'/ftp/' + repo_name
					exec('cd '+ destination_folder +' && ssh-agent bash -c "ssh-add '+ folder +'/id_rsa; git pull origin master --allow-unrelated-histories"', (error, stdout, stderr) => {
						if (error) {
							console.error(`exec error: ${error}`);
							return;
						}
						else{
							exec('cd '+ destination_folder + ' && git diff --name-only HEAD~0 HEAD~1', (error, stdout, stderr) => {
								var files = stdout.split('\n')
								for(var i = 0; i < files.length - 1; i++){
									dispatch(files[i])
								}
							})
						}
					});
				}
			}
		}
	}
	catch(e){

	}

  	res.end('Hello World');
}).listen(3000);
const http = require('http');
const url = require('url');
const { Client } = require('ssh2');
const { readFileSync } = require('fs');
const { exec } = require('child_process');

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
    var server_address = url.parse(req.url,true).query.server_address
    var server_username = url.parse(req.url,true).query.server_username
    var server_port = url.parse(req.url,true).query.server_port
  	res.statusCode = 200;
  	res.setHeader('Content-Type', 'text/plain');


  	try{
		if(check == 'ssh'){
			var destination_folder = server_root + '/users/'+ unique_id
			exec('rm '+ destination_folder +' -rf && mkdir ' + destination_folder + ' && ssh-keygen -f ' + destination_folder + '/id_rsa -q -N "" && cd ' + destination_folder + ' && touch authorized_keys && cp id_rsa.pub authorized_keys && zip -r '+ host +'_keys.zip id_rsa id_rsa.pub authorized_keys ' );
		}
		else{
			const conn = new Client();
			conn.on('ready', (req) => {
				if(check == 'configure'){
					conn.exec('cd '+ server_root +' && rm .git -rf && git init && git config user.email "'+ email +'" && git config user.name "'+ name +'" && git add . && git commit -am "initial commit" && git remote add gitzila '+ git_url +' && git fetch gitzila && git checkout gitzila/master', (err, stream) => {
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
					conn.exec('cd '+ server_root +' && git pull gitzila master --allow-unrelated-histories', (err, stream) => {
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
	}
	catch(e){

	}

  	res.end('Hello World');
}).listen(3000);
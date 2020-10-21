function apps(host, username, token, filter = null, callback){
    if(filter == null)
    {
        if(host == 'github')
        {
        	$.ajax({
				url: 'https://api.github.com/users/'+ username +'/repos?sort=pushed_at&order=desc',
				headers: { 'Authorization': 'token ' + token },
			})
            .done(function(data){
        		callback(data)
        	})
            .fail(function(error){
                console.log(error)
            })
        }

        if(host == 'gitlab')
        {
        	$.ajax({
				url: 'https://gitlab.com/api/v4/users/'+ username +'/projects?access_token='+ token,
			})
        	.done(function(data){
        		callback(data)
        	})
            .fail(function(error){
                console.log(error)
            })
        }

        if(host == 'bitbucket')
        {
        	$.ajax({
				url: 'https://api.bitbucket.org/2.0/repositories/'+ username +'?access_token='+ token +'&pagelen=5&sort=-updated_on',
			})
        	.done(function(data){
        		callback(data.values)
        	})
            .fail(function(error){
                console.log(error)
            })
        }
    }
    else
    {
        if(host == 'github')
        {
        	$.ajax({
				url: 'https://api.github.com/search/repositories?q='+ filter +'+in:name+user:'+ username +'&sort=pushed_at&order=desc',
				headers: { 'Authorization': 'token ' + token },
			})
        	.done(function(data){
        		callback(data.items)
        	})
            .fail(function(error){
                console.log(error)
            })
        }

        if(host == 'gitlab')
        {
            callback(null)
        }

        if(host == 'bitbucket')
        {
        	$.ajax({
				url: 'https://api.bitbucket.org/2.0/repositories/'+ username +'?access_token='+ token +'&pagelen=5&sort=-updated_on&q=name~"'+ filter +'"',
			})
        	.done(function(data){
        		callback(data.values)
        	})
            .fail(function(error){
                console.log(error)
            })
        } 
    }
}

function loadTable(host, data){
	var table = $('#table-body')
    if(host == 'github'){
		data.forEach(function(app){
            var d = new Date(app.pushed_at)
            var dateString = d.getFullYear() + "-" + normalize(d.getMonth() + 1) + "-" + normalize(d.getDay()) + " " + normalize(d.getHours()) + ":" + normalize(d.getMinutes()) + ":" + normalize(d.getSeconds())
			table.append('\
                <tr>\
                    <td class="py-3">'+ app.name +'</td>\
                    <td>'+ dateString +'</td>\
                    <td><a href="/dashboard/app/'+ app.name +'" class="btn btn-sm btn-primary">deployment settings</a> </td>\
                </tr>\
			')
		})
    }
    if(host == 'bitbucket'){
		data.forEach(function(app){
            var d = new Date(app.updated_on)
            var dateString = d.getFullYear() + "-" + normalize(d.getMonth() + 1) + "-" + normalize(d.getDay()) + " " + normalize(d.getHours()) + ":" + normalize(d.getMinutes()) + ":" + normalize(d.getSeconds())
			table.append('\
                <tr>\
                    <td class="py-3">'+ app.name +'</td>\
                    <td>'+ dateString +'</td>\
                    <td><a href="/dashboard/app/'+ app.name +'" class="btn btn-sm btn-primary">deployment settings</a> </td>\
                </tr>\
			')
		})
    }
    if(host == 'gitlab'){
		data.forEach(function(app){
            var d = new Date(app.last_activity_at)
            var dateString = d.getFullYear() + "-" + normalize(d.getMonth() + 1) + "-" + normalize(d.getDay()) + " " + normalize(d.getHours()) + ":" + normalize(d.getMinutes()) + ":" + normalize(d.getSeconds())
			table.append('\
                <tr>\
                    <td class="py-3">'+ app.name +'</td>\
                    <td>'+ dateString +'</td>\
                    <td><a href="/dashboard/app/'+ app.name +'" class="btn btn-sm btn-primary">deployment settings</a> </td>\
                </tr>\
			')
		})
    }
}

function hooks(host, username, data, token, callback){
    if(host == 'github'){
        callback(null)
    }
    if(host == 'gitlab'){
        callback(null)
    }
    if(host == 'bitbucket'){
        $.ajax({
            url: 'https://api.bitbucket.org/2.0/repositories/'+ username +'/'+ data.slug +'/hooks?access_token='+ token,
        })
        .done(function(data){
            callback(data.values)
        })
        .fail(function(error){
            console.log(error)
        })
    }
}

function setHook(host, username, data, url, hook, token, callback){
    if(host == 'github'){
        callback(null)
    }
    if(host == 'gitlab'){
        callback(null)
    }
    if(host == 'bitbucket'){
        $.ajax({
            type: 'POST',
            url: 'https://api.bitbucket.org/2.0/repositories/'+ username +'/'+ data.slug +'/hooks',
            headers: {
                'Authorization' : 'Bearer ' + token
            },
            data: {
                'description' : 'gitzila',
                'url' : url,
                'active' : true,
                'events' : ['repo:push']
            }
        })
        .done(function(data){
            callback(data.values)
        })
        .fail(function(error){
            console.log(error)
        })
    }
}

function updateHook(host, username, data, url, hook, token, callback){
    if(host == 'github'){
        callback(null)
    }
    if(host == 'gitlab'){
        callback(null)
    }
    if(host == 'bitbucket'){
        $.ajax({
            type: 'PUT',
            url: 'https://api.bitbucket.org/2.0/repositories/'+ username +'/'+ data.slug +'/hooks/' + hook.uuid,
            headers: {
                'Authorization' : 'Bearer ' + token
            },
            data: {
                'description' : 'gitzila',
                'url' : url,
                'active' : true,
                'events' : ['repo:push']
            }
        })
        .done(function(data){
            callback(data.values)
        })
        .fail(function(error){
            console.log(error)
        })
    }
}

function normalize(number){
    return ("0" + number).slice(-2)
}
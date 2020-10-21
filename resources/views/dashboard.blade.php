@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid page__heading-container">
        <div class="page__heading d-flex align-items-center">
            <div class="flex">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a></li>
                        <li class="breadcrumb-item">{{ user()->host }}</li>
                    </ol>
                </nav>
            </div>
            <!-- <a href="javascript:void(0)" onclick="return confirm('are you sure you want to generate new ssh key pair') ? ssh() : ''" class="btn btn-success ml-3">Generate new ssh key</a> -->
        </div>
    </div>



    <div class="container-fluid page__container">
        <div class="card card-form">
            <div class="row no-gutters">
                <div class="col-lg-12 card-body">
                    <p><strong class="headings-color">Hint</strong> : <code class="text-danger"> please read carefully, if you skip any line, your app may not work</code></p>
                    <p class="text-muted">
                     1. If your app is running on Shared Hosting, contact your provider and ask them to enable ssh for you. If ssh is not enabled on your Shared Hosting, this option will not work.
                     If your app is running on a reseller hosting, you probably may not have ssh. <br><br>
                     2. Ssh is generated per account not per project, so if you have multiple project in one account, you need only one ssh. 
                     Anytime you generate new ssh, you will have to replace your previous ssh with the new one both in server and in your {{ user()->host }} account for your apps to continue deploying automatically. <br><br>
                     3. If there are files or folders that are not part of your git repo but crucial in your app, you will have to ignore them manually using ".gitignore" file else our system will unlink them while trying to configure the app
                 </p> 
                </div>
            </div>
        </div>
        <div class="card card-form">
            <div class="row no-gutters">
                <div class="col-lg-12 card-body">
                    <p><strong class="headings-color">Step One : </strong> add ssh to your server and to your {{ user()->host }} account</p>
                    <p class="text-muted">
                    1. If you have not generated ssh or you feel that your previous ssh is compromised, click on this link to <a href="javascript:void(0)" onclick="return confirm('are you sure you want to generate new ssh key pair') ? ssh() : ''">generate new ssh for your  {{ user()->host }} account.</a> <br>
                    2. Click on this link to  <a href="{{ route('download') }}">download the ssh keys you generated.</a> <br>
                    3. Login to your server home folder and unzip the contents of "keys.zip" you downloaded into ".ssh" folder <br>
                    4. The next thing to do is to copy the content of "id_rsa.pub", which is your public key, to your {{ user()->host }} account. follow this tutorial and learn 
                    @if(user()->host == 'bitbucket')
                        <a target="_blank" href="https://support.atlassian.com/bitbucket-cloud/docs/set-up-an-ssh-key/#-Step-3.-Add-the-public-key-to-your-Account-settings">how to add public key to a bitbucket account</a>
                    @endif
                    @if(user()->host == 'github')
                        <a target="_blank" href="https://docs.github.com/en/free-pro-team@latest/github/authenticating-to-github/adding-a-new-ssh-key-to-your-github-account">how to add public key to a github account</a>
                    @endif
                    @if(user()->host == 'gitlab')
                        <a target="_blank" href="https://docs.gitlab.com/ee/ssh/README.html#adding-an-ssh-key-to-your-gitlab-account">how to add public key to a gitlab account</a>
                    @endif
                </p>
                </div>
            </div>
        </div>
        
        <div class="card card-form">
            <div class="row no-gutters">
                <div class="col-lg-12 card-body">
                    <p><strong class="headings-color">Step Two : </strong> create a webhook</p>
                    <p class="text-muted">A webhook is a service that notifies our system about events happening in your repository. Fill in the details below correctly and use the resulting url to create a repo:push hook that will tell our system to deploy your app whenever you make a push to the repository.
                        <br>
                        1. After filling the forms correctly, click on complete server configuration.<br>
                        2. Copy the resulting url and head to your repository to create a webhook with it.<br>Click on the link below and learn 
                        @if(user()->host == 'bitbucket')
                            <a target="_blank" href="https://support.atlassian.com/bitbucket-cloud/docs/manage-webhooks/#Managewebhooks-create_webhook">how to create webhook in a bitbucket account</a>
                        @endif
                        @if(user()->host == 'github')
                            <a target="_blank" href="https://docs.github.com/en/free-pro-team@latest/developers/webhooks-and-events/creating-webhooks#setting-up-a-webhook">how to create webhook in a github account</a>
                        @endif
                        @if(user()->host == 'gitlab')
                            <a target="_blank" href="https://stackoverflow.com/questions/17157969/how-do-i-create-a-gitlab-webhook">how to create webhook in a gitlab account</a>
                        @endif
                        <br><br>
                        ** Note that server root folder is the FULL PATH to the final destination folder  where our system will dump your repository. Make sure it is correct. 
                        Server address can be IP address or a name pointing to the IP address of the server. The default SFTP Port is 22 if yours is different, replace 22 with your stfp port
                    </p>
                </div>
            </div>
        </div>
        <div class="card card-form d-flex flex-column flex-sm-row">
            <div class="card-form__body card-body-form-group flex">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="filter_name">Server Root Folder *</label>
                            <input onkeyup="generateUrl()" id="server_root" type="text" class="form-control" placeholder="e.g    /var/www/emit/" value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="filter_name">Repository Name *</label>
                            <input onkeyup="generateUrl()" id="repo_name" type="text" class="form-control" placeholder="e.g    emit" value="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-form d-flex flex-column flex-sm-row">
            <div class="card-form__body card-body-form-group flex">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="filter_name">Server Address *</label>
                            <input onkeyup="generateUrl()" id="server_address" type="text" class="form-control" placeholder="e.g    emit.com.ng" value="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="filter_name">Server Username *</label>
                            <input onkeyup="generateUrl()" id="server_username" type="text" class="form-control" placeholder="e.g    emitcomng" value="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="filter_name">Server SFTP Port *</label>
                            <input onkeyup="generateUrl()" id="server_port" type="text" class="form-control" placeholder="e.g    22" value="22">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-form d-flex flex-column flex-sm-row">
            <div class="card-form__body card-body-form-group flex">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="filter_name">Your Resulting Webhook url</label>
                            <input id="url" type="text" class="form-control" placeholder="" value="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="javascript:void(0)" onclick="configure()" class="btn btn-primary">complete server configure</a>
    </div>
    <script>
        var app_url = "{{ env('APP_URL') }}"
        var host = "{{ user()->host }}"
        var unique_id = "{{ user()->unique_id }}"
        var app_name = "{{ request('app_name') }}"

        function generateUrl(){
            var server_root = $('#server_root').val()
            var repo_name = $('#repo_name').val()
            var server_address = $('#server_address').val()
            var server_username = $('#server_username').val()
            var server_port = $('#server_port').val()
            var url = app_url + '/hook/' + host + '/' + unique_id + '?server_root=' + server_root + '&repo_name=' + repo_name + '&server_address=' + server_address + '&server_username=' + server_username + '&server_port=' + server_port
            $('#url').val(url)
        }

        function configure(){
            var server_root = $('#server_root').val()
            var repo_name = $('#repo_name').val()
            var server_address = $('#server_address').val()
            var server_username = $('#server_username').val()
            var server_port = $('#server_port').val()

            if(server_root == "" || repo_name == "" || server_address == "" || server_username == "" || server_port == ""){
                alert("all fields marked with * are required and must be correct")
            }
            else{
                $.get("{{ route('configure') }}", { server_root : server_root, repo_name : repo_name, server_address : server_address, server_username : server_username, server_port : server_port })
                .done(function(response){
                    alert(response.message);
                })
            }
        }

        function ssh(){
            $.get("{{ route('ssh') }}")
            .done(function(response){
                alert(response.message);
            })
        }
    </script>
@endsection

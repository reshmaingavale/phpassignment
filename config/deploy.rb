set :application, "demo"
set :repository,  "github.com/reshmaingavale/phpassignment.git"
set :deploy_to, "/var/www/cake_test" 

location : "cake_test.weboapps.com"
set :scm, :git

set :branch, "demo"
set :keep_releases, 3
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `git`, `mercurial`, `perforce`, `subversion` or `none`


role :web, location                          # Your HTTP server, Apache/etc
role :app, location                          # This may be the same as your `Web` server
role :db, location, :primary => true # This is where Rails migrations will run

set :user, 'root'
set :ssh_options, {:forward_agent => true}

after "deploy","deploy:cleanup"

namespace :deploy do
  task :start do ; end
  task :stop do ; end
  task :restart, :roles => :app do
    run "/etc/init.d/apache2 restart"
    run "/etc/init.d/apache2 reload"
    clear_cache
  end
end

# if you want to clean up old releases on each deploy uncomment this:
# after "deploy:restart", "deploy:cleanup"

# if you're still using the script/reaper helper you will need
# these http://github.com/rails/irs_process_scripts

# If you are using Passenger mod_rails uncomment this:
# namespace :deploy do
#   task :start do ; end
#   task :stop do ; end
#   task :restart, :roles => :app, :except => { :no_release => true } do
#     run "#{try_sudo} touch #{File.join(current_path,'tmp','restart.txt')}"
#   end
# end




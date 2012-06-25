
set :application, "indymultiples"

set :deploy_to, "/var/www/cake_test/"

location = "cake_test.weboapps.com"

role :web, location                          # Your HTTP server, Apache/etc
role :app, location                          # This may be the same as your `Web` server

set :scm, :git
set :repository,  ""
set :branch, ""
set :keep_releases, 3


set :user, ''
set :password, ''
set :ssh_options, {:forward_agent => true}

namespace :deploy do
    task :start do ; end
    task :stop do ; end
    task :restart, :roles => :app do
        run "/etc/init.d/apache2 restart"
        run "/etc/init.d/apache2 reload"
        clear_cache
    end

    task :finalize_update, :roles => :app do

        run "cp #{current_release}/wp-config.php.default #{shared_path}/wp-config.php"

        run "ln -sf #{shared_path}/wp-config.php #{current_release}/wp-config.php"
    end
end




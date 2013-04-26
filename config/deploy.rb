# INITIAL CONFIGURATION
#set :application, "siclom.omegaingenieros.com"
set :application, "dev.omegaingenieros.com"
set :export, :remote_cache
set :keep_releases, 5
set :cakephp_app_path, "app"
set :cakephp_core_path, "cake"
default_run_options[:pty] = true # Para pedir la contraseña de la llave publica de github via consola, sino sale error de llave publica.

# DEPLOYMENT DIRECTORY STRUCTURE
#set :deploy_to, "/home/embalao/siclom.omegaingenieros.com"
set :deploy_to, "/home/embalao/dev.omegaingenieros.com"

# USER & PASSWORD
set :user, 'embalao'
set :password, 'rr40r900343'

# ROLES
#role :app, "siclom.omegaingenieros.com"
#role :web, "siclom.omegaingenieros.com"
#role :db, "siclom.omegaingenieros.com", :primary => true
role :app, "dev.omegaingenieros.com"
role :web, "dev.omegaingenieros.com"
role :db, "dev.omegaingenieros.com", :primary => true

# VERSION TRACKER INFORMATION
set :scm, :git
set :use_sudo, false
set :repository,  "git@github.com:bloomtec/omega.git"
set :branch, "master"

# TASKS
namespace :deploy do
  
  task :start do ; end
  
  task :stop do ; end
  
  task :restart, :roles => :app, :except => { :no_release => true } do
    #run "cp /home/embalao/siclom.omegaingenieros.com/current/. /home/embalao/siclom.omegaingenieros.com/ -R"
    run "cp /home/embalao/dev.omegaingenieros.com/current/. /home/embalao/dev.omegaingenieros.com/ -R"
  end
  
end
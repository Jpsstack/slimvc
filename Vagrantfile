# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "chef/centos-7.0"

  # Set the name of the VM (NOTE: not the hostname). See: http://stackoverflow.com/a/17864388/100134
  config.vm.define :slimvc do |slimvc|
  end

  config.vm.network "private_network", ip: "192.168.30.10"
  config.vm.hostname = "slimvc.dev"

  # Use rbconfig to determine if we're on a windows host or not.
  require 'rbconfig'
  is_windows = (RbConfig::CONFIG['host_os'] =~ /mswin|mingw|cygwin/)
  if is_windows
    # Provisioning configuration for shell script.
    config.vm.provision "shell" do |sh|
      sh.path = "provisioning/JJG-Ansible-Windows/windows.sh"
      sh.args = "provisioning/playbook.yml"
    end
  else
    # Provisioning configuration for Ansible (for Mac/Linux hosts).
    config.vm.provision "ansible" do |ansible|
      ansible.playbook = "provisioning/playbook.yml"
      ansible.sudo = true
    end
  end

  config.vm.synced_folder ".", "/vagrant"
  config.vm.synced_folder ".", "/var/www/htdocs/slimvc"
  config.vm.post_up_message = "\n\nProvisioning is done, visit http://slimvc.dev for your application! \n\n"

end

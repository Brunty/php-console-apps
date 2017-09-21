Vagrant.require_version ">= 1.5"

Vagrant.configure("2") do |config|

    config.vm.provider :virtualbox do |v|
        v.name = "php-console-apps"
        v.customize [ "modifyvm", :id, "--name", "php-console-apps", "--memory", 1024, "--natdnshostresolver1", "on", "--cpus", 1 ]
    end

    config.vm.box = "ubuntu/xenial64"
    config.vm.network :private_network, ip: "192.168.66.199"

    config.ssh.forward_agent = true

    config.vm.provision :shell, path: "ansible/provision.sh", args: ["php-console-apps"]
    config.vm.synced_folder "./", "/app"
end

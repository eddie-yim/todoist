Vagrant.require_version ">= 1.5"

Vagrant.configure("2") do |config|
  # provider
  config.vm.provider :virtualbox do |v|
    v.name = "practice"
    v.customize [
      "modifyvm", :id,
      "--name", "practice_vm",
      "--memory", 512,
      "--natdnshostresolver1", "on",
      "--cpus", 1,
    ]
  end

  config.vm.box = "ubuntu/xenial32"

  config.vm.network :private_network, ip: "192.168.33.21"

  config.ssh.forward_agent = true

  # provision
  config.vm.provision "ansible" do |ansible|
    ansible.playbook = "ansible/playbook.yml"
    ansible.inventory_path = "ansible/inventories/dev"
    ansible.limit = "all"
  end

  config.vm.synced_folder "./", "/vagrant", type: "nfs"
end

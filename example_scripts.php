<?php

// IP Address Pools for Hosts
$start_ip = ip2long('10.0.0.1');
$end_ip = ip2long('10.0.20.1');
$hostIPAddresses = [];

while($start_ip <= $end_ip){
  $hostIPAddresses[] = long2ip($start_ip);
  $start_ip++;
}

// GUID Generator
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
 
function generate_string($input, $strength = 16) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
 
    return $random_string;
}
$storagePools = $hosts = '';
// Generate Hosts
for ($i=0;$i<1000;$i++) {
    $hosts .= '
        {
          "id": 10000000' . str_pad($i, 5, "0", STR_PAD_LEFT) . ',
          "name": "chariot' . $i . '.kemo.labs",
          "type": "ManageIQ::Providers::Vmware::InfraManager::HostEsx",
          "hostname": "chariot' . $i . '.kemo.labs",
          "ipaddress": "' . $hostIPAddresses[$i] . '",
          "power_state": "on",
          "guid": "' . generate_string($permitted_chars, 8) . '-' . generate_string($permitted_chars, 4) . '-' . generate_string($permitted_chars, 4) . '-' . generate_string($permitted_chars, 4) . '-' . generate_string($permitted_chars, 12) . '",
          "uid_ems": "chariot' . $i . '.kemo.labs",
          "ems_ref": "host-1' . str_pad($i, 3, "0", STR_PAD_LEFT) . '",
          "mac_address": null,
          "maintenance": false,
          "vmm_vendor": "vmware",
          "vmm_version": "7.0.0",
          "vmm_product": "ESXi",
          "vmm_buildnumber": "15843807",
          "archived": false,
          "cpu_cores_per_socket": 16,
          "cpu_total_cores": 32,
          "ems_cluster": null,
          "hardware": {
            "memory_mb": 262081
          }
        },
    ';
}

// Generate storage pools
for ($i=0;$i<1000;$i++) {
  $storagePools .= '
  {
    "id": 10000000' . str_pad($i, 5, "0", STR_PAD_LEFT) . ',
    "name": "VMDataStore' . $i . '",
    "location": "' . generate_string($permitted_chars, 8) . '-' . generate_string($permitted_chars, 8) . '-' . generate_string($permitted_chars, 4) . '-' . generate_string($permitted_chars, 12) . '",
    "store_type": "VMFS",
    "total_space": 1798785990656,
    "free_space": 1616213180416,
    "uncommitted": 533999196622,
    "storage_domain_type": null,
    "host_storages": [
      {
        "ems_ref": "datastore-1' . str_pad($i, 3, "0", STR_PAD_LEFT) . '",
        "host": {
          "ems_ref": "host-1' . str_pad($i, 3, "0", STR_PAD_LEFT) . '"
        }
      }
    ]
  },
  ';
}


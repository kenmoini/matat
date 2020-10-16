<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MATAT</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

        <style>
            body {
                font-family: 'Nunito';
            }
            .polyglotLogo {
                max-width: 330px;
                max-height: 330px;
                background: url(https://polyglot.ventures/img/polyglotLR.png) no-repeat;
                background-position-y: center;
                background-position-x: left;
                min-width: 8rem;
                min-height: 8rem;
                background-size: cover;
                display: inline-block;
                filter: saturate(0);
            }
            .polyglotLogo:hover ,
            .polyglotLogo:active,
            .polyglotLogo:focus {
              background-position-x: right;
              cursor: pointer;
            }
        </style>
    </head>
    <body class="bg-light">
    <div class="container" id="app">
  <div class="py-5 text-center">
    <div class="polyglotLogo"></div>
    <h2>Migration Analytics Toolkit....Assistive Toolkit</h2>
    <p class="lead">Have you ever wished the Red Hat Migration Analytics Toolkit was easier to gain insight from?<br/>  Well, if we're working with Big Al rules, you now have two wishes left...</p>
  </div>

  <div class="row">
    <div class="col-md-4 order-md-2 mb-4">
      <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-muted">Manifest</span>
        <span class="badge badge-secondary badge-pill">@{{ manifest.length }}</span>
      </h4>
      <ul class="list-group mb-3">
        <li class="list-group-item d-flex justify-content-between lh-condensed">
          <div>
            <h6 class="my-0">Empty Manifest</h6>
          </div>
        </li>
      </ul>

        <div class="form-group">
        
            <button type="submit" class="btn btn-secondary" v-if="manifest.length">Export</button>
        
        </div>

    </div>
    <div class="col-md-8 order-md-1">
        <h4 class="mb-3">
          1) Infrastructure
          <span class="pull-right"><button class="btn btn-outline" type="button" data-toggle="modal" data-target="#infraModalCenter"><i class="fa fa-plus"></i></span>
        </h4>
        <table class="table table-striped table-hover" v-if="infrastructure.length">
            <thead>
              <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Version</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(infra, index) in infrastructure">
                <td>@{{ infra.friendlyName }}</td>
                <td>@{{ infra.typeName }}</td>
                <td>@{{ infra.version }}</td>
                <td>
                  <button class="btn btn-sm btn-danger rmInfra" :data-index="index"><i class="fa fa-trash"></i></button>
                </td>
              </tr>
            </tbody>
        </table>
        <hr class="mb-4">

        <h4 class="mb-3">2) Clusters & Hosts
          <span class="pull-right" v-if="infrastructure.length"><button class="btn btn-outline" type="button" data-toggle="modal" data-target="#clustersModalCenter"><i class="fa fa-plus"></i></span>
        </h4>
        <table class="table table-striped table-hover" v-if="clustersAndHosts.length">
            <thead>
              <tr>
                <th>Name</th>
                <th>Hosts</th>
                <th>Base DNS</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(cluster, index) in clustersAndHosts">
                <td>@{{ cluster.friendlyName }}</td>
                <td>
                  <strong>@{{ cluster.hostCount }} Hosts</strong><br />
                  <span class="text-small">@{{ cluster.hostSocketCount }} Sockets / @{{ cluster.hostCoresPerSocketCount }} Cores each</span><br />
                  <span class="text-small">@{{ cluster.hostRAM }}GB RAM w/ @{{ cluster.totalStorageSize }}GB Total Storage</span>
                </td>
                <td>@{{ cluster.clusterBaseDNSName }}</td>
                <td>
                  <button class="btn btn-sm btn-danger rmCluster" :data-index="index"><i class="fa fa-trash"></i></button>
                </td>
              </tr>
            </tbody>
        </table>
        <hr class="mb-4">

        <h4 class="mb-3">3) Licenses
          <span class="pull-right" v-if="clustersAndHosts.length"><button class="btn btn-outline" type="button" data-toggle="modal" data-target="#licensesModalCenter"><i class="fa fa-plus"></i></span>
        </h4>
        <hr class="mb-4">

        <h4 class="mb-3">4) VMs & Workloads
          <span class="pull-right" v-if="licenses.length"><button class="btn btn-outline" type="button" data-toggle="modal" data-target="#vmWorkloadsModalCenter"><i class="fa fa-plus"></i></span>
        </h4>

        <hr class="mb-4" v-if="vmsAndWorkloads.length">
        <button class="btn btn-primary btn-lg btn-block" type="submit" v-if="vmsAndWorkloads.length">Add to Manifest</button>
      </form>
    </div>
  </div>

  <footer class="my-5 pt-5 text-muted text-center text-small">
    <p class="mb-1">Copyleft 2020 <a href="https://polyglot.ventures">Polyglot Ventures</a> - Respective Trademarks owned by <a href="https://redhat.com">Red Hat</a></p>
  </footer>

  <!-- Modals -->
  <!-- Add Infrastructure Modal -->
  <div class="modal fade" id="infraModalCenter" tabindex="-1" role="dialog" aria-labelledby="infraModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="infraModalCenterTitle">Add Infrastructure</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="addInfraForm" name="addInfraForm" method="POST" action="">
            <div class="form-group">
              <label for="infraFriendlyName">Infrastructure Friendly Name</label>
              <input class="form-control" name="infraFriendlyName" id="infraFriendlyName" />
            </div>
            <div class="form-group">
              <label for="infraTypeDropDown">Infrastructure Type</label>
              <select id="infraTypeDropDown" name="infraTypeDropDown" class="form-control">
                <option value="">Select an IaaS option...</option>
                <option value="vmware">VMWare vSphere</option>
                <option value="rhv" disabled>Red Hat Virtualization</option>
                <option value="openstack" disabled>Red Hat OpenStack</option>
              </select>
            </div>
            <div class="form-group infraVersionHolder d-none" id="infraVersion-vmware">
              <label for="infraVersion-VMWDropDown">vSphere Version</label>
              <select id="infraVersion-VMWDropDown" name="infraVersion-VMWDropDown" class="form-control">
                <option value="">Select a vSphere version</option>
                <option value="7">7</option>
                <option value="6.5">6.5</option>
                <option value="6">6</option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="addInfraType" class="btn btn-primary">Add</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Add Clusters and Hosts Modal -->
  <div class="modal fade" id="clustersModalCenter" tabindex="-1" role="dialog" aria-labelledby="clustersModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="clustersModalCenterTitle">Add Clusters & Hosts</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="addClusterForm" name="addClusterForm" method="POST" action="">
            <div class="form-group">
              <label for="clusterFriendlyName">Cluster Friendly Name</label>
              <input class="form-control" name="clusterFriendlyName" id="clusterFriendlyName" placeholder="Data Analytics Cluster" />
            </div>
            <div class="form-group">
              <label for="clusterBaseDNSName">Cluster Base DNS Name</label>
              <input class="form-control" name="clusterBaseDNSName" id="clusterBaseDNSName" placeholder="da.example.com" />
            </div>
            <hr />
            <div class="form-group">
              <label for="clusterHostCount">Host Count</label>
              <input type="number" class="form-control" id="clusterHostCount" name="clusterHostCount" min="1" step="1" />
            </div>
            <div class="form-group">
              <label for="clusterHostSocketCount">Per Host Socket Count</label>
              <input type="number" class="form-control" id="clusterHostSocketCount" name="clusterHostSocketCount" min="1" step="1" />
            </div>
            <div class="form-group">
              <label for="clusterHostCoresPerSocketCount">Per Host Cores Per Socket Count</label>
              <input type="number" class="form-control" id="clusterHostCoresPerSocketCount" name="clusterHostCoresPerSocketCount" min="1" step="1" />
            </div>
            <div class="form-group">
              <label for="clusterHostTotalRAM">Per Host Total RAM in GB</label>
              <input type="number" class="form-control" id="clusterHostTotalRAM" name="clusterHostTotalRAM" />
            </div>
            <hr />
            <h5>
              Cluster Data Stores
              <span class="pull-right"><button class="btn btn-outline" type="button" id="addStoragePool"><i class="fa fa-plus"></i></span>
            </h5>
            <div class="clusterStoragePoolsHolder">
              <div class="storagePoolHolders border-left ml-3 pl-3" id="clusterStoragePoolHolder-0">
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" class="form-control storagePoolName" id="clusterStoragePoolName-0" name="clusterStoragePoolName-0" placeholder="Pool Name" />
                    <div class="input-group-append">
                      <div class="input-group-button">
                        <button type="button" class="btn btn-danger removePool"><i class="fa fa-trash"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col">
                    <input type="number" class="form-control storagePoolSize" id="clusterStoragePoolSize-0" name="clusterStoragePoolSize-0" placeholder="Size in GB" />
                  </div>
                  <div class="col">
                    <input type="number" class="form-control storagePoolUsage" id="clusterStoragePoolUsage-0" name="clusterStoragePoolUsage-0" min="0" max="100" placeholder="Usage in %" />
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="addClusterAndHosts" class="btn btn-primary">Add</button>
        </div>
      </div>
    </div>
  </div>
  
</div> <!-- .container#app -->

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

        <script type="text/javascript">
          jQuery(document).ready(function() {
            var app = new Vue({
              el: '#app',
              data: {
                infrastructure: [],
                clustersAndHosts: [],
                licenses: [],
                vmsAndWorkloads: [],
                manifest: []
              }
            });
            // Infrastructure Type Dropdown Change
            jQuery("#infraTypeDropDown").change(function() {
              var infraType = this.value;
              jQuery(".infraVersionHolder").addClass('d-none');
              jQuery('#infraVersion-' + infraType).removeClass('d-none');
            });
            // Add Infrastructure Type
            jQuery("#infraModalCenter").on('click', "#addInfraType", function(e) {
              e.preventDefault();
              var infraType;
              var infraVersion;
              let validForm = true;
              if (!jQuery("#infraFriendlyName").val()) {
                validForm = false;
                jQuery("#infraFriendlyName").addClass('warning');
              }
              switch (jQuery("#infraTypeDropDown").val()) {
                case "vmware":
                  infraType = 'VMWare vSphere';
                  if (jQuery('#infraVersion-VMWDropDown').val()) {
                    infraVersion = jQuery('#infraVersion-VMWDropDown').val();
                  }
                  else {
                    validForm = false;
                  }
                break;
                default:
                  validForm = false;
                break;
              }
              if (validForm) {
                app.infrastructure.push({ typeName: infraType, version: infraVersion, friendlyName: jQuery("#infraFriendlyName").val() });
                jQuery("#addInfraForm").trigger("reset");
                jQuery("#infraModalCenter").modal('hide');
              }
            });
            // Remove Infrastructure Type Button
            jQuery("#app").on('click', 'button.rmInfra', function(e) {
              e.preventDefault();
              let targetIn = jQuery(this).data('index');
              if (targetIn > -1) {
                app.infrastructure.splice(targetIn, 1);
              }
            });
            // Add Storage Pool Button
            jQuery("#app").on('click', 'button#addStoragePool', function(e) {
              if (jQuery(".clusterStoragePoolsHolder .storagePoolHolders").length) {
                var clusterStoragePoolCount = jQuery(".storagePoolHolders").last().attr('id');
                clusterStoragePoolCount = clusterStoragePoolCount.replace('clusterStoragePoolHolder-', '');
                clusterStoragePoolCount = (parseInt(clusterStoragePoolCount) + 1);
              }
              else { var clusterStoragePoolCount = 0; }
              jQuery(".clusterStoragePoolsHolder").append('<div class="storagePoolHolders border-left ml-3 pl-3" id="clusterStoragePoolHolder-' + clusterStoragePoolCount + '"><div class="form-group"><div class="input-group"><input type="text" class="form-control storagePoolName" id="clusterStoragePoolName-' + clusterStoragePoolCount + '" name="clusterStoragePoolName-' + clusterStoragePoolCount + '" placeholder="Pool Name" /><div class="input-group-append"><div class="input-group-button"><button type="button" class="btn btn-danger removePool"><i class="fa fa-trash"></i></button></div></div></div></div><div class="form-group row"><div class="col"><input type="number" class="form-control storagePoolSize" id="clusterStoragePoolSize-' + clusterStoragePoolCount + '" name="clusterStoragePoolSize-' + clusterStoragePoolCount + '" placeholder="Size in GB" /></div><div class="col"><input type="number" class="form-control storagePoolUsage" id="clusterStoragePoolUsage-' + clusterStoragePoolCount + '" name="clusterStoragePoolUsage-' + clusterStoragePoolCount + '" min="0" max="100" placeholder="Usage in %" /></div></div></div>');
            });
            // Remove Storage Pool Button
            jQuery("#app").on('click', '.storagePoolHolders button.removePool', function(e) {
              jQuery(this).parent().parent().parent().parent().parent().remove();
            });
            // Add Clusters & Host Button
            jQuery("#clustersModalCenter").on('click', "#addClusterAndHosts", function(e) {
              e.preventDefault();
              let validForm = true;
              if (!jQuery("#clusterFriendlyName").val() || !jQuery("#clusterBaseDNSName").val() 
                  || !jQuery("#clusterHostCount").val()
                  || !jQuery("#clusterHostSocketCount").val()
                  || !jQuery("#clusterHostCoresPerSocketCount").val()
                  || !jQuery("#clusterHostTotalRAM").val()
                  || !jQuery(".clusterStoragePoolsHolder .storagePoolHolders").length
                ) {
                validForm = false;
              }
              
              var storagePools = [];
              var totalStorageSize = 0;
              var totalStorageUsage = 0; //TODO: Figure out how to average the sum of the storage pools consumption

              jQuery(".clusterStoragePoolsHolder .storagePoolHolders").each(function(index) {
                if (
                  !jQuery(this).find('.storagePoolName').val() ||
                  !jQuery(this).find('.storagePoolSize').val() ||
                  !jQuery(this).find('.storagePoolUsage').val()
                ) {
                  validForm = false;
                }
                else {
                  storagePools.push({
                    poolName: jQuery(this).find('.storagePoolName').val(),
                    poolSize: jQuery(this).find('.storagePoolSize').val(),
                    poolUsage: jQuery(this).find('.storagePoolUsage').val(),
                  });
                  totalStorageSize = totalStorageSize + parseInt(jQuery(this).find('.storagePoolSize').val());
                }
              });

              if (validForm) {

                app.clustersAndHosts.push({
                  friendlyName: jQuery("#clusterFriendlyName").val(),
                  clusterBaseDNSName: jQuery("#clusterBaseDNSName").val(),
                  hostCount: jQuery("#clusterHostCount").val(),
                  hostSocketCount: jQuery("#clusterHostSocketCount").val(),
                  hostCoresPerSocketCount: jQuery("#clusterHostCoresPerSocketCount").val(),
                  hostRAM: jQuery("#clusterHostTotalRAM").val(),
                  storagePools: storagePools,
                  totalStorageSize: totalStorageSize
                });
                jQuery("#addClusterForm").trigger("reset");
                jQuery("#clustersModalCenter").modal('hide');
              }
            });
            // Remove Cluster and Hosts Button
            jQuery("#app").on('click', 'button.rmCluster', function(e) {
              e.preventDefault();
              let targetIn = jQuery(this).data('index');
              if (targetIn > -1) {
                app.clustersAndHosts.splice(targetIn, 1);
              }
            });
            // Disable default submits on subforms
            jQuery("#addClusterForm, #addInfraForm").on('submit', function(e) {
              e.preventDefault();
            });
          });
        </script>
    </body>
</html>

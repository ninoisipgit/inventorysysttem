<template>
    <div>
        <section class="content">
            <h1>Supplier</h1>
            <div class="box-body">

                <div class="row">
                    <div class="col-sm-12">
                            <button type="button" id="btnAdd" class="btn btn-info btn-sm" data-toggle="modal" data-target="#supplierModal" v-on:click="showModal('0');">Add Supplier</button>
                    </div>
                </div>
                <div>&nbsp;</div>
                <div class="table-responsive">
                    <table class="row-border" id="supplierTable" style="width:100%">
                        <thead>
                            <tr>
                                <th width="35%" class="text-center">Supplier / Brand Name</th>
                                <th width="35%" class="text-center">Contact Number</th>
                                <th class="text-center">Edit</th>
                                <th class="text-center">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="supplier in targetList">
                                <td>{{supplier.supplier}}</td>
                                <td>{{supplier.contact}}</td>
                                <td>
                                    <center><button type="button" id="btnEdit" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#supplierModal" v-on:click="showModal(supplier.id);">Edit</button></center>
                                </td>
                                <td>
                                    <center><button type="button" id="btnDel" class="btn btn-danger btn-sm" v-on:click="delSupplier(supplier.id);">delete</button></center>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- ADD  MODAL -->
            <div class="modal modal-default fade" id="supplierModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <div class="modal-header">
                                    <template v-if="supplierId > 0">
                                        <h4 class="modal-title">Edit Supplier</h4>
                                    </template>
                                    <template v-else>
                                        <h4 class="modal-title">Add Supplier</h4>
                                    </template>
                                </div>
                                <div class="modal-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Supplier / Brand Name" v-model="supplier">
                                            <span v-if="errors" style="color:red">{{errors.supplier}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="number" class="form-control" placeholder="Contact Number" v-model="contact">
                                            <span v-if="errors" style="color:red">{{errors.contact}}</span>
                                        </div>
                                    </div>
                                </div>
                                   
                                </div>
                                <div class="modal-footer">
                                    <button type="button" name="btnSave" class="btn btn-sm btn-info" v-on:click="saveSupplier();">
                                        <template v-if="supplierId > 0">Update</template>
                                        <template v-else>Save</template>
                                        Supplier
                                    </button>
                                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" id="clrBtn">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END ADD  MODAL -->
        </section>
    </div>
</template>

<script>
import { Script } from 'vm';
    export default{
        props: [],
        data(){
            return {
                supplier : '',
                contact : '',
                supplierId : 0,
                targetList : {},
                errors : {}
            }
        },
        created(){
            this.getSupplier();
        },
        mounted (){
            $('#supplierTable').DataTable( {
                "destroy" : true,
                "retrieve" : true,
                "select" : true,
                "ordering" : true,
            });
        },

        beforeUpdate: function() {
            $('#supplierTable').DataTable().destroy();

        },

        updated: function(){
            $('#supplierTable').DataTable( {
                "destroy" : true,
                "retrieve" : true,
                "select" : true,
                "ordering" : true,
            });
        },
       
        methods:{
            showModal(id){
                // $('#categoryModal').modal
                // ({
                //     backdrop: 'static',
                //     keyboard: false
                // });
                this.supplier = '';
                this.contact = '';
                this.supplierId = 0;
                if(id > 0){
                    var obj = this.targetList.find(function (obj) { 
                        return obj.id === id;
                    });
                    this.supplier = obj.supplier;
                    this.contact = obj.contact;
                    this.supplierId =  obj.id;;
                }
            },


            clearModal (){
                $("#clrBtn")[0].click();
            },

            saveSupplier(){
                var axiosUrl = "saveSupplier";
                var data = {
                    supplier : this.supplier,
                    contact : this.contact,
                    id : this.supplierId
                }

                let self = this;
                axios.post(axiosUrl, data).then(response => {
                    var data = response.data;
                    if(data.statusCode == 0){
                        alert("Successfully Saved!");
                        this.clearModal();
                        this.getSupplier();
                    }
                }).catch(error => {
                    this.errors = error.response.data.errors;
                });

            },

            getSupplier(){

                var axiosUrl = "getSupplierList";
                var data = {
                }

                let self = this;
                axios.get(axiosUrl, data).then(response => {
                    self.targetList = response.data;
                }).catch(error => {
                    self.errors = error.response.data.errors;
                });
    
            },

            delSupplier(id){
                
                var axiosUrl = "delSupplier";
                var data = {
                    id : id,
                }

                let self = this;
                axios.post(axiosUrl, data).then(response => {
                    var data = response.data;
                    if(data.statusCode == 0){
                        alert("Successfully deleted!");
                        this.getSupplier();
                    }
                }).catch(error => {
                    this.errors = error.response.data.errors;
                });
    
            },
        },
    };
</script>
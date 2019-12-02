<template>
    <div>
        <section class="content">
            <h1>Category</h1>

            <div class="box-body">

                <div class="row">
                    <div class="col-sm-12">
                            <button type="button" id="btnAdd" class="btn btn-info btn-sm" data-toggle="modal" data-target="#categoryModal" v-on:click="showModal('0');">Add Category</button>
                    </div>
                </div>
                <div>&nbsp;</div>
            <template >
                <div class="table-responsive">
                    <table class="row-border" id="categoryTable" style="width:100%">
                        <thead>
                            <tr>
                                <th width="70%" class="text-center">Category</th>
                                <th class="text-center">Edit</th>
                                <th class="text-center">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="category in targetList">
                                <td>{{category.name}}</td>
                                <td>
                                    <center><button type="button" id="btnEdit" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#categoryModal" v-on:click="showModal(category.id);">Edit</button></center>
                                </td>
                                <td>
                                    <center><button type="button" id="btnDel" class="btn btn-danger btn-sm" v-on:click="delCategory(category.id);">delete</button></center>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </template>
            </div>
            <!-- ADD  MODAL -->
            <div class="modal modal-default fade" id="categoryModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <div class="modal-header">
                                    <template v-if="categoryId > 0">
                                        <h4 class="modal-title">Edit Category</h4>
                                    </template>
                                    <template v-else>
                                        <h4 class="modal-title">Add Category</h4>
                                    </template>
                                </div>
                                <div class="modal-body">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Category" v-model="category">
                                            <span v-if="errors" style="color:red">{{errors.category}}</span>
                                        </div>
                                    </div>
                                </div>
                                   
                                </div>
                                <div class="modal-footer">
                                    <button type="button" name="btnSave" class="btn btn-sm btn-info" v-on:click="saveCategory();">
                                        <template v-if="categoryId > 0">Update</template>
                                        <template v-else>Save</template>
                                        Category
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
    export default{
        props: [],
        data(){
            return {
                category : '',
                categoryId : 0,
                targetList : {},
                errors : {}
            }
        },
        created(){
            this.getCategory();
        },
        mounted (){
            $('#categoryTable').DataTable( {
                "destroy" : true,
                "retrieve" : true,
                "select" : true,
                "ordering" : true,
            });
        },

        beforeUpdate: function() {
            $('#categoryTable').DataTable().destroy();

        },

        updated: function(){
            $('#categoryTable').DataTable( {
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
                this.category = '';
                this.categoryId = 0;
                if(id > 0){
                    var obj = this.targetList.find(function (obj) { 
                        return obj.id === id;
                    });
                    this.category = obj.name;
                    this.categoryId =  obj.id;;
                }
            },


            clearModal (){
                $("#clrBtn")[0].click();
            },

            saveCategory(){
                var axiosUrl = "saveCategory";
                var data = {
                    category : this.category,
                    id : this.categoryId
                }

                let self = this;
                axios.post(axiosUrl, data).then(response => {
                    var data = response.data;
                    if(data.statusCode == 0){
                        alert("Successfully Saved!");
                        this.clearModal();
                        this.getCategory();
                    }
                }).catch(error => {
                    this.errors = error.response.data.errors;
                });

            },


            getCategory(){

                var axiosUrl = "getCategoryList";
                var data = {
                }

                let self = this;
                axios.get(axiosUrl, data).then(response => {
                    self.targetList = response.data;
                }).catch(error => {
                    self.errors = error.response.data.errors;
                });
    
            },

            delCategory(id){
                
                var axiosUrl = "delCategory";
                var data = {
                    id : id,
                }

                let self = this;
                axios.post(axiosUrl, data).then(response => {
                    var data = response.data;
                    if(data.statusCode == 0){
                        alert("Successfully deleted!");
                        this.getCategory();
                    }
                }).catch(error => {
                    this.errors = error.response.data.errors;
                });
    
            },

        }
    };
</script>

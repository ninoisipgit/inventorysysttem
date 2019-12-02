<template>
    <div>
        <section class="content">
            <h1>Product</h1>
            <div class="box-body">

                <div class="row">
                    <div class="col-sm-12">
                            <button type="button" id="btnAdd" class="btn btn-info btn-sm" data-toggle="modal" data-target="#productModal" v-on:click="showModal('0');">Add Product</button>
                    </div>
                </div>
                <div>&nbsp;</div>
                <div class="table-responsive">
                    <table class="row-border" id="productTable" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">Product</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Supplier / Brand</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Edit</th>
                                <th class="text-center">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="product in targetList">
                                <td>{{product.product}}</td>
                                <td>{{product.categoryName}}</td>
                                <td>{{product.supplierName}}</td>
                                <td>{{product.quantity}}</td>
                                <td>{{product.price}}</td>
                                <td>
                                    <center><button type="button" id="btnEdit" class="btn btn-info btn-sm" data-toggle="modal" data-target="#productModal" v-on:click="showModal(product.id);"><i class="fas fa-pencil-alt">
                                        </i> Edit</button></center>
                                </td>
                                <td>
                                    <center><button type="button" id="btnDel" class="btn btn-danger btn-sm" v-on:click="delProduct(product.id);"><i class="fas fa-trash">
                                        </i> Delete</button></center>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
             <!-- ADD  MODAL -->
            <div class="modal modal-default fade" id="productModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <div class="modal-header">
                                    <template v-if="productId > 0">
                                        <h4 class="modal-title">Edit Product</h4>
                                    </template>
                                    <template v-else>
                                        <h4 class="modal-title">Add Product</h4>
                                    </template>
                                </div>
                                <div class="modal-body">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Product Name" v-model="product">
                                            <span v-if="errors" style="color:red">{{errors.product}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select class="browser-default custom-select" v-model="supplierId">
                                                <template v-for="value in supplierList">
                                                    <option v-bind:value="value.id">{{value.supplier}}</option>
                                                </template>
                                            </select>
                                            <span v-if="errors" style="color:red">{{errors.supplier}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select class="browser-default custom-select" v-model="categoryId">
                                                <template v-for="value in categoryList">
                                                    <option v-bind:value="value.id">{{value.name}}</option>
                                                </template>
                                            </select>
                                            <span v-if="errors" style="color:red">{{errors.category}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="number" class="form-control"  id="replyNumber" min="1" data-bind="value:replyNumber" placeholder="quantity" v-model="quantity" />
                                            <span v-if="errors" style="color:red">{{errors.quantity}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="number" class="form-control" placeholder="Price per piece" v-model="price">
                                            <span v-if="errors" style="color:red">{{errors.price}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Total Price" v-model="computedPrice" readonly>
                                        </div>
                                    </div>
                                </div>
                                   
                                </div>
                                <div class="modal-footer">
                                    <button type="button" name="btnSave" class="btn btn-sm btn-info" v-on:click="saveProduct();">
                                        <template v-if="productId > 0">Update</template>
                                        <template v-else>Save</template>
                                        Product
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

                productId : 0,
                product : '',
                categoryId : '',
                supplierId : '',
                quantity : 0,
                price : '',

                targetList : {},
                supplierList : {},
                categoryList : {},
                errors : {}
            }
        },
        created(){
            this.getProduct();
            this.getSupplier();
            this.getCategory();
        },
        mounted (){
            $('#productTable').DataTable( {
                "destroy" : true,
                "retrieve" : true,
                "select" : true,
                "ordering" : true,
            });
        },

        beforeUpdate: function() {
            $('#productTable').DataTable().destroy();

        },

        updated: function(){
            $('#productTable').DataTable( {
                "destroy" : true,
                "retrieve" : true,
                "select" : true,
                "ordering" : true,
            });
        },

        computed: {

            computedPrice : function (){
                return  "TOTAL ₱"+this.quantity * this.price;
            },
        },
        methods:{

            getCategory(){

                var axiosUrl = "getCategoryList";
                var data = {
                }

                let self = this;
                axios.get(axiosUrl, data).then(response => {
                    self.categoryList = response.data;
                }).catch(error => {
                    self.errors = error.response.data;
                });
    
            },
            
            getSupplier(){

                var axiosUrl = "getSupplierList";
                var data = {
                }

                let self = this;
                axios.get(axiosUrl, data).then(response => {
                    self.supplierList = response.data;
                }).catch(error => {
                    self.errors = error.response.data.errors;
                });
    
            },
            showModal(id){

                this.product = '';
                this.categoryId = '';
                this.supplierId = '';
                this.quantity = '';
                this.price = '';
                this.productId = 0;

                if(id > 0){
                    var obj = this.targetList.find(function (obj) { 
                        return obj.id === id;
                    });

                    this.product = obj.product;
                    this.categoryId = obj.category;
                    this.supplierId = obj.supplier;
                    this.quantity = obj.quantity;
                    this.price = obj.price;
                    this.productId = obj.id;
                }
            },


            clearModal (){
                $("#clrBtn")[0].click();
            },

            saveProduct(){
                var axiosUrl = "saveProduct";
                var data = {

                    id : this.productId,
                    product : this.product,
                    category : this.categoryId,
                    supplier : this.supplierId,
                    quantity : this.quantity,
                    price : this.price,
                }

                let self = this;
                axios.post(axiosUrl, data).then(response => {
                    var data = response.data;
                    if(data.statusCode == 0){
                        alert("Successfully Saved!");
                        this.clearModal();
                        this.getProduct();
                    }
                }).catch(error => {
                    this.errors = error.response.data;
                });

            },

            getProduct(){

                var axiosUrl = "getProductList";
                var data = {
                }

                let self = this;
                axios.get(axiosUrl, data).then(response => {
                    self.targetList = response.data;
                }).catch(error => {
                    self.errors = error.response.data.errors;
                });
    
            },

            delProduct(id){
                
                var axiosUrl = "delProduct";
                var data = {
                    id : id,
                }

                let self = this;
                axios.post(axiosUrl, data).then(response => {
                    var data = response.data;
                    if(data.statusCode == 0){
                        alert("Successfully deleted!");
                        this.getProduct();
                    }
                }).catch(error => {
                    this.errors = error.response.data.errors;
                });
    
            },
        }
    };
</script>
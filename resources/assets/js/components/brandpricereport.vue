<template>
    <div>
        <section class="content">
            <h1>Supplier / Brand Report by Total Amount</h1>
            <div class="box-body">
                <div>&nbsp;</div>
                <div class="table-responsive">
                    <table class="row-border" id="amountTable" style="width:100%">
                        <thead>
                            <tr>
                                <th width="35%" class="text-center">Supplier / Brand Name</th>
                                <th width="35%" class="text-center">Contact Number</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item,index) in targetList">
                                <template v-if="index == 'grand_total_quantity' || index == 'grand_total_amount'">
                                </template>
                                <template v-else>
                                <td>{{index}}</td>
                                <td>{{item.contact}}</td>
                                <td align="right">{{item.quantity}}</td>
                                <td align="right">{{formatPrice(item.amount)}}</td>
                                </template>
                            </tr>
                            <tr>
                                <td></td>
                                <td><strong>TOTAL</strong></td>
                                <td align="right"><strong>{{targetList.grand_total_quantity}}</strong></td>
                                <td align="right"><strong>{{formatPrice(targetList.grand_total_amount)}}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</template>


<script>
import { Script } from 'vm';
    export default{
        props: [],
        data(){
            return {

                targetList : {},
            }
        },
        created(){
            this.getAmountReport();
        },
        mounted (){
            $('#amountTable').DataTable( {
                "destroy" : true,
                "retrieve" : true,
                "select" : true,
                "ordering" : true,
            });
        },

        beforeUpdate: function() {
            $('#amountTable').DataTable().destroy();

        },

        updated: function(){
            $('#amountTable').DataTable( {
                "destroy" : true,
                "retrieve" : true,
                "select" : true,
                "ordering" : true,
            });
        },

        computed: {
        },

        methods:{

            formatPrice(value) {
                let val = (value/1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },

            getAmountReport(){

                var axiosUrl = "getAmountList";
                var data = {
                }

                let self = this;
                axios.get(axiosUrl, data).then(response => {
                    self.targetList = response.data;
                }).catch(error => {
                    self.errors = error.response.data.errors;
                });
    
            },
        }
    };
</script>
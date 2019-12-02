<template>
     <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                    <h3>{{formatPrice(targetList.grand_total_amount)}}</h3>
    
                    <p>TOTAL AMOUNT</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-bag"></i>
                    </div>
                    <a href="/pricereport" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                    <h3>{{targetList.grand_total_quantity}}</sup></h3>
    
                    <p>TOTAL ITEMS</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="/pricereport" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
                </div>
            </div>
        </div>
    </section>
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
<template lang="">
<div>
    
<div class="container my-5 vld-parent" >
    
    <form @submit.prevent="store()" >
    <div class="row g-3">
        <div class="col-6">
            <div class="card-body">
               <input v-model="invoice.table_no" type="text" class="form-control " placeholder="Table/Pax" autocomplete="off" >
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Qty</th>
                        <th>Description</th>
                        <th>Price</th></th>
                        <th>Amount</th>
                        <th><button type="button" class="btn btn-primary btn-xs" @click='addTableRow()' style="margin-bottom:0; !important;"><i class="fas fa-plus-circle" ></i></button></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, k) in invoice.tableRows">
                        <td>
                            <input  type="number" v-model="item.qty" class="form-control " placeholder="Qty" autocomplete="off" @change='calculateAmount(item)'>
                        </td>
                        <td>
                            <input  type="text" v-model='item.description' class="form-control " placeholder="Description" autocomplete="off" >
                        </td>
                        <td>
                            <input  type="number" v-model='item.price' class="form-control " placeholder="Price" autocomplete="off" @change='calculateAmount(item)'>
                        </td>
                        <td>
                            <input readonly type="text" v-model='item.amount' class="form-control " placeholder="0" autocomplete="off" >
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger" @click='removeTableRow(k,item)'><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right">Sub Total</td>
                        <td class="text-right">{{invoice.sub_total}}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">Tax 10%</td>
                        <td class="text-right">{{invoice.tax}}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">Total</td>
                        <td class="text-right">{{invoice.total}}</td>
                    </tr>
                </tfoot>
            </table>
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-primary"  > Save</button>
          </div>
        </div>
        <div class="col-6">
            <table class="table text-center" >
                <thead>
                    <tr>
                        <th>Table/Pax</th>
                        <th>Receipt No</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="invoice in invoices.data" :key="invoice.id">
                        <td >{{invoice.table_no}}</td>
                        <td>{{invoice.receipt_no}}</td>
                        <td>
                            <button type="button" class="btn btn-success" @click="printInvoice(invoice.id)" ><i class="fa fa-print"></i></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <pagination :data="invoices" @pagination-change-page="view"></pagination>
            </div>
        </div>
    </div>
    </form>   
</div>


</div>
</template>

<script>

import Form from 'vform'
import 'vue-loading-overlay/dist/vue-loading.css'

export default {
    
    data() {
        return {
            invoice: new Form({
                table_no: '',
                receipt_no:'',
                sub_total:0,
                tax:0,
                total:0,
                tableRows:[{
                    qty:'',
                    description:'',
                    price:'',
                    amount:0
                }],
            }),
            invoices:{},
            imgModal:false,
            
        }
    },
    methods: {
        create() {
            this.product.clear();
            this.isEditMode = false;
            this.product.name = '',
            this.product.price = ''
        },
        store() {
            this.$Progress.start();
             this.isLoading = true;
             let loader = this.$loading.show();
            this.invoice.post('/api/')
                .then(res => {
                     this.view();
                    this.invoice.table_no="";
                    this.invoice.sub_total=0;
                    this.invoice.tax=0;
                    this.invoice.total=0;
                    for(var i = this.invoice.tableRows.length - 1; i > 0; i--){
                      
                        this.invoice.tableRows.splice(i, i);
                        this.invoice.tableRows[0]="";

                    }
                    
                    this.isLoading = false;
                    loader.hide();
                    Toast.fire({
                        icon: 'success',
                        title: 'Created successfully'
                    })
                    this.$Progress.finish()
                })
                .catch(error=>{
                    this.message=error.response.data.message;
                    this.$Progress.fail();
                    this.isLoading = false
                    loader.hide()
                });
        },
        
        view(page = 1) {
            
            this.$Progress.start();
            let loader = this.$loading.show();
            
            this.invoice.get(`/api?page=${page}`)
                .then(res => {
                  
                    this.invoices = res.data;
                    this.$Progress.finish();
                    loader.hide()
                })
                .catch(error=>{
                    this.$Progress.fail();
                    loader.hide()
                });
        },
      
        
        calculateTotal(){
            var sub_total,total;
            sub_total=this.invoice.tableRows.reduce(function(sum,item){
                var amount_toal=parseFloat(item.amount);
                if(!isNaN(amount_toal)){
                    return sum+amount_toal;
                }
            },0);
            
            this.invoice.sub_total=sub_total.toFixed(2);
            this.invoice.tax=(sub_total /10).toFixed(2);
            total=(sub_total /10 )+sub_total;
            total=parseFloat(total);
            if(!isNaN(total)){
                this.invoice.total=total.toFixed(2)
            }else{
                this.invoice.total='0.00'
            }
        },
        addTableRow: function () { 
            this.invoice.tableRows.push({
                qty:'',
                description:'',
                price:'',
                amount:0});
            
            },
        removeTableRow(i,item){
            var idx=this.invoice.tableRows.indexOf(item);
            if(idx >-1){
                this.invoice.tableRows.splice(idx,1)
            }
            this.calculateTotal();
        },
        calculateAmount(item){
            var amount=parseFloat(item.qty) * parseFloat(item.price);
            if(!isNaN(amount)){
                item.amount=amount.toFixed(2);
            }
            this.calculateTotal();
        },
        printInvoice(id){
          
          this.$router.push(`/getInvoice/${id}`)
        },
       
    },
    created() {
        this.view();
    }
}
</script>

<style lang="">

</style>

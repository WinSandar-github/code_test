<template lang="">
<div>
    
<div class="container my-5 vld-parent" >
   
    <div >
        <div class="card">
            <div class="card-body" v-for="invoice in invoices">
                <div class="row">
                    <div class="col-2">
                        <strong >Date</strong>
                    </div>
                    <div class="col-2">
                        <strong >:{{currentDateTime()}}</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <strong >Receipt No</strong>
                    </div>
                    <div class="col-2">
                        <strong >:{{invoice.receipt_no}}</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <strong >Table/Pax</strong>
                    </div>
                    <div class="col-2">
                        <strong >:{{invoice.table_no}}</strong>
                    </div>
                </div>
            <table class="table " >
                <thead>
                    <tr>
                        <th>Qty</th>
                        <th>Description</th>
                        <th>Amount</th>
                        
                    </tr>
                </thead>
                <tbody >
                    <tr v-for="item in invoice.item" >
                        <td >
                            {{item.qty}}
                        </td>
                        <td>
                            {{item.description}}
                        </td>
                        
                        <td >
                            ${{item.amount}}
                        </td>
                        
                    </tr>
                </tbody>
                <tfoot >
                    <tr>
                        <td colspan="2" class="text-right">SUB TOTAL</td>
                        <td class="text-right">${{invoice.sub_total}}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">TAX 10%</td>
                        <td class="text-right">${{invoice.tax}}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">TOTAL</td>
                        <td class="text-right">${{invoice.total}}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    </div>
</div>
</div>
</template>

<script>

import 'vue-loading-overlay/dist/vue-loading.css'


export default {
    
    data() {
        return {
            invoices:{}
            
        }
    },
    methods: {
       currentDateTime(){
        const current=new Date();
        const date=current.getDate()+"-"+(current.getMonth()+1)+"-"+current.getFullYear();
        var time;
        if(current.getHours > 12){
            time=current.getHours()+":"+current.getMinutes()+" AM";
        }else{
            time=(current.getHours()-12)+":"+current.getMinutes()+" PM";
        }
        
        const dateTime=date+" "+time;
        return dateTime;
       }
        
    },
    created() {
        
        this.$Progress.start();
            let loader = this.$loading.show();
            
            axios.get(`/api/getInvoice/${this.$route.params.id}`)
                .then(res => {
                    this.invoices = res.data;
                    this.$Progress.finish();
                    loader.hide()
                })
                .catch(error=>{
                    this.$Progress.fail();
                    loader.hide()
                });
    }
}
</script>

<style lang="">

</style>

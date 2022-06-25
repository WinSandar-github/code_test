<template>
    <div>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <router-link class="nav-link" aria-current="page" to="/" exact>Image</router-link>
            </li>
            
            <li class="nav-item">
               
                <router-link class="nav-link " to="/product">
                    Product
                </router-link>
            </li>
            
        </ul>
        
    </div>
</template>
Vue.component('header',{
  template:`
  
  `
}
)
<script>

export default({
    name:'HeaderComponent',
   
})
</script>
<style>
.active{
    color: #495057 !important;
    background-color: #fff !important;
    border-color: #dee2e6 #dee2e6 #fff !important;
}
</style>
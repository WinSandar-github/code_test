<template>

  <div>
    <Header/>

    
    <div class="container my-5 vld-parent">
         
               <div class="row m-3">
                    <div class="col-md-12">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" @click="viewLogoImg()"><i class="fas fa-eye"></i></button>
                            <button type="button" class="btn btn-primary" @click="smallerImg()"><i class="fas fa-minus-circle"></i></button>
                            <button type="button" class="btn btn-primary" @click="enlargeImg()"><i class="fas fa-plus-circle"></i></button>
                        
                    </div>
                </div>
                <div class="row justify-content-right m-3"><img  v-bind:src="myImage" style="width:200px;height:100px;" alt="" id="logo" data-bs-toggle="modal" data-bs-target="#imgModal" @click="viewImg()"></div>
         
    </div>
    <div class="modal fade" id="imgModal" tabindex="-1" aria-labelledby="imgModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
            <h1 class="modal-title"></h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                <img  v-bind:src="myImage" >
            </div>
            
        </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
            <h1 class="modal-title"></h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body" style="overflow: hidden;">
            
                <img v-bind:src="myImage" style="width: 100%;height: 100%;">
            </div>
            
            
            
        </div>
        </div>
    </div>

   
    
  </div>
</template>
<script>
import Header from './HeaderComponent.vue';

export default {
  components:{
    Header,
   
  },
  data(){
    return{
     
      myImage:'https://i.ytimg.com/vi/ByH9LuSILxU/maxresdefault.jpg',
     
      img:'',
      imgWidth:'',
      imgHeight:'',
      
    }
  },
  methods:{
    
         viewLogoImg(){
           
            this.myImage=this.myImage
           
        },
        viewImg(){
              
              this.myImage=this.myImage
             
        },
        enlargeImg(){
          this.img = document.getElementById("logo");
          
            if(this.img.style.width=="200px" && this.img.style.height=="100px"){
              this.imgWidth='60%',
              this.imgHeight='5%'
            }else{
              this.imgWidth='100%',
              this.imgHeight='10%'
            }
            this.img.style.width=this.imgWidth;
            this.img.style.height=this.imgHeight;
            this.img.style.transition ="transform 0.25s ease";
        },
        smallerImg(){
          this.img = document.getElementById("logo");
            if(this.imgWidth=="100%" && this.imgHeight=="10%"){
              this.imgWidth='60%',
              this.imgHeight='5%'
            }else{
              this.imgWidth='200px',
              this.imgHeight='100px'
            }
            this.img.style.width=this.imgWidth;
            this.img.style.height=this.imgHeight;
            this.img.style.transition ="transform 0.25s ease";
            
        },
        

  },
//   created() {
//         this.$Progress.start();
//         let loader = this.$loading.show();
//     }
  
};
</script>

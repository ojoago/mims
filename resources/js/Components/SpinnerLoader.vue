<script setup>
    
import { computed } from "vue";
import store from '@/store';

// const store = useStore();
// const spin =  store.state.spinnerLoader;
// const spinner = true;
const spinner = computed(() => store?.state?.spinnerLoader);
const notification = computed(() => store?.state?.notification);
</script>

<template>
    <div>
      <div class="modal-overlay z-100" v-if="spinner">
          <div calss="spinner">
            <span class="loader"></span>
            <!-- <div id="spinner-text">loging Out...</div> -->
          </div>
      </div>

      <div class="notification text-white animate-fade-in-down" v-if="notification?.status" :class="`${notification?.type}`">
        {{ notification?.message }}
      </div>
    </div>
</template>


<style scoped>
  .primary{
        @apply bg-indigo-600 text-white  hover:bg-indigo-500 focus-visible:outline-indigo-600;
    }
    .secondary{
        @apply bg-gray-600 text-white hover:bg-indigo-500 focus-visible:outline-indigo-600;
    }
    .bordered{
        @apply bg-white text-indigo-800 border border-indigo-500 hover:bg-gray-50 focus-visible:outline-indigo-600;
    }
    .warning{
        @apply bg-yellow-400 text-white hover:bg-red-500 focus-visible:outline-red-600;
    }
    .danger{
        @apply bg-red-600 text-white hover:bg-red-500 focus-visible:outline-red-600;
    }
    .success{
        @apply bg-optimal text-white hover:bg-optimal focus-visible:outline-optimal
    }

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100%;
    background: transparent;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999999;
}

.notification{
  position: fixed;
  align-items: center;
  justify-content: center;
  z-index: 99999;
  top: 5px;
  left: 5px;
  padding: 10px;
  border-radius: 10px;
  transition: all .5s ease;
}
  

.spinner {
    display: block;
    margin-top:50% !important;
    margin-left:50% !important;
    float: center;
    width: 150px;
  }


 /* loader  */
        /* .loader {
            animation: rotate 1s infinite;
            height: 50px;
            width: 50px;
        }

        .loader:before,
        .loader:after {
            border-radius: 50%;
            content: "";
            display: block;
            height: 20px;
            width: 20px;
        }

        .loader:before {
            animation: ball1 1s infinite;
            background-color: #686060;
            box-shadow: 30px 0 0 #ff3d00;
            margin-bottom: 10px;
        }

        .loader:after {
            animation: ball2 1s infinite;
            background-color: #ff3d00;
            box-shadow: 30px 0 0 #f1ff;
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg) scale(0.8)
            }

            50% {
                transform: rotate(360deg) scale(1.2)
            }

            100% {
                transform: rotate(720deg) scale(0.8)
            }
        }

        @keyframes ball1 {
            0% {
                box-shadow: 30px 0 0 #ff3d00;
            }

            50% {
                box-shadow: 0 0 0 #ff3d00;
                margin-bottom: 0;
                transform: translate(15px, 15px);
            }

            100% {
                box-shadow: 30px 0 0 #ff3d00;
                margin-bottom: 10px;
            }
        }

        @keyframes ball2 {
            0% {
                box-shadow: 30px 0 0 #fff;
            }

            50% {
                box-shadow: 0 0 0 #3b3a3a;
                margin-top: -20px;
                transform: translate(15px, 15px);
            }

            100% {
                box-shadow: 30px 0 0 #4b4949;
                margin-top: 0;
            }
        } */
         
/* .loader {
  width: 48px;
  height: 48px;
  position: relative;
}
.loader::before , .loader::after{
  content: '';
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50% , -50%);
  width: 48em;
  height: 48em;
  background-image:
    radial-gradient(circle 10px, #6b6767 100%, transparent 0),
    radial-gradient(circle 10px, #6b6767 100%, transparent 0),
    radial-gradient(circle 10px, #6b6767 100%, transparent 0),
    radial-gradient(circle 10px, #6b6767 100%, transparent 0),
    radial-gradient(circle 10px, #6b6767 100%, transparent 0),
    radial-gradient(circle 10px, #6b6767 100%, transparent 0),
    radial-gradient(circle 10px, #6b6767 100%, transparent 0),
    radial-gradient(circle 10px, #6b6767 100%, transparent 0);
  background-position: 0em -18em, 0em 18em, 18em 0em, -18em 0em,
                       13em -13em, -13em -13em, 13em 13em, -13em 13em;
    background-repeat: no-repeat;
  font-size: 0.5px;
  border-radius: 50%;
  animation: blast 1s ease-in infinite;
}
.loader::after {
  font-size: 1px;
  background: #4b4747;
  animation: bounce 1s ease-in infinite;
}

@keyframes bounce {
  0% , 100%{ font-size: 0.75px }
  50% { font-size: 1.5px }
}
@keyframes blast {
  0% , 40% {
    font-size: 0.5px;
  }
  70% {
    opacity: 1;
    font-size: 4px;
  }
   100% {
     font-size: 6px;
    opacity: 0;
  }
}
     */

     .loader {
        animation: rotate 1s infinite;
        height: 50px;
        width: 50px;
    }

  .loader:before,
  .loader:after {
    border-radius: 50%;
    content: "";
    display: block;
    height: 20px;
    width: 20px;
  }
  .loader:before {
    animation: ball1 1s infinite;
    background-color: #732f2f;
    box-shadow: 30px 0 0 #7b3d3d;
    margin-bottom: 10px;
  }
  .loader:after {
    animation: ball2 1s infinite;
    background-color: #313030;
    box-shadow: 30px 0 0 #787777;
  }

  @keyframes rotate {
    0% { transform: rotate(0deg) scale(0.8) }
    50% { transform: rotate(360deg) scale(1.2) }
    100% { transform: rotate(720deg) scale(0.8) }
  }

  @keyframes ball1 {
    0% {
      box-shadow: 30px 0 0 #343231;
    }
    50% {
      box-shadow: 0 0 0 #474646;
      margin-bottom: 0;
      transform: translate(15px, 15px);
    }
    100% {
      box-shadow: 30px 0 0 #ff3d00;
      margin-bottom: 10px;
    }
  }

  @keyframes ball2 {
    0% {
      box-shadow: 30px 0 0 #064c78;
    }
    50% {
      box-shadow: 0 0 0 #706e6e;
      margin-top: -20px;
      transform: translate(15px, 15px);
    }
    100% {
      box-shadow: 30px 0 0 #297bbe;
      margin-top: 0;
    }
  }
  


</style>
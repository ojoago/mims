import{m as f,p,M as v,h as b,o as h,d as g,a as n,w as i,z as r,E as c,b as e,D as d,n as k,t as C,y as S,g as B,N as E}from"./app-B8N_3nHs.js";const N={class:"fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50","scroll-region":""},z={class:"px-4 py-2 flex justify-between"},D={class:"font-bold"},V={__name:"Modal",props:{show:{type:Boolean,default:!1},maxWidth:{type:String,default:"2xl"},closeable:{type:Boolean,default:!0},title:{type:String,default:null}},emits:["close","submit"],setup(s,{emit:y}){const a=s,m=y;f(()=>a.show,()=>{a.show?document.body.style.overflow="hidden":document.body.style.overflow=null});const l=()=>{a.closeable&&m("close")},w=()=>{m("submit")},u=o=>{o.key==="Escape"&&a.show&&l()};p(()=>document.addEventListener("keydown",u)),v(()=>{document.removeEventListener("keydown",u),document.body.style.overflow=null});const x=b(()=>({sm:"sm:max-w-sm",md:"sm:max-w-md",lg:"sm:max-w-lg",xl:"sm:max-w-xl","2xl":"sm:max-w-2xl","4xl":"sm:max-w-4xl w-full","6xl":"sm:max-w-6xl w-full"})[a.maxWidth]);return(o,t)=>(h(),g(E,{to:"body"},[n(d,{"leave-active-class":"duration-200"},{default:i(()=>[r(e("div",N,[n(d,{"enter-active-class":"ease-out duration-300","enter-from-class":"opacity-0","enter-to-class":"opacity-100","leave-active-class":"ease-in duration-200","leave-from-class":"opacity-100","leave-to-class":"opacity-0"},{default:i(()=>[r(e("div",{class:"fixed inset-0 transform transition-all",onClick:l},t[0]||(t[0]=[e("div",{class:"absolute inset-0 bg-gray-500 opacity-75"},null,-1)]),512),[[c,s.show]])]),_:1}),n(d,{"enter-active-class":"ease-out duration-300","enter-from-class":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95","enter-to-class":"opacity-100 translate-y-0 sm:scale-100","leave-active-class":"ease-in duration-200","leave-from-class":"opacity-100 translate-y-0 sm:scale-100","leave-to-class":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"},{default:i(()=>[r(e("div",{class:k(["mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto",x.value])},[e("div",z,[e("span",D,C(s.title),1),e("span",{onClick:l,class:"rounded-full bg-red-500 w-5 text-center cursor-pointer"},"X")]),t[1]||(t[1]=e("hr",null,null,-1)),s.show?S(o.$slots,"default",{key:0}):B("",!0),t[2]||(t[2]=e("hr",null,null,-1)),e("div",{class:"py-2 px-8"},[e("button",{onClick:w,class:"bg-optimal text-white px-4 py-2 rounded mr-2"},"Submit"),e("button",{onClick:l,class:"bg-red-500 text-white px-4 py-2 rounded"},"Close")])],2),[[c,s.show]])]),_:3})],512),[[c,s.show]])]),_:3})]))}};export{V as _};
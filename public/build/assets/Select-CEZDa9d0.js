import{_ as c}from"./TextInput-yIcStZbp.js";import{o as t,c as a,a as m,b as r,t as i,F as n,r as v,u as f}from"./app-BUbXf8zH.js";const g=["name","id"],b={value:"",selected:""},S=["value","v-if"],y={__name:"Select",props:{label:String,placeholder:String,options:Object,error:String,modelvalue:String,val:{type:String,default:"id"}},emits:["update:model-value"],setup(e,{emit:o}){let s=o;return(h,d)=>(t(),a(n,null,[m(c,{for:e.label,value:e.label},null,8,["for","value"]),r("select",{name:e.label,id:e.label,onChange:d[0]||(d[0]=l=>{f(s)("update:model-value",l.target.value)}),class:"mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"},[r("option",b,i(e.placeholder),1),(t(!0),a(n,null,v(e.options,(l,u)=>(t(),a("option",{key:u,value:e.val=="id"?l.id:l.text,"v-if":l.id==e.modelvalue&&e.val=="id"||l.text==e.modelvalue?"selected":""},i(l.text),9,S))),128))],40,g)],64))}};export{y as _};
import{_ as n}from"./TextInput-D-PxJzzM.js";import{o as a,c as l,a as o,b as d,t as s,F as u,r as c,L as m}from"./app-BrrR7Ozw.js";const f=["value"],g={value:"",disabled:""},v=["value","selected"],V={__name:"BaseSelect",props:{label:{type:String,default:""},defaultValue:{type:String,default:"Select an Option",required:!1},selected:{type:[String,Number],default:""},options:{type:[Array,Object],required:!0},val:{type:String,default:"id"}},emits:["update:model-value"],setup(e,{emit:b}){return(r,y)=>(a(),l(u,null,[o(n,{for:e.label,value:e.label},null,8,["for","value"]),d("select",m({class:"mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm",value:e.selected},{...r.$attrs,onChange:t=>{r.$emit("update:modelValue",t.target.value)}}),[d("option",g,s(e.defaultValue),1),(a(!0),l(u,null,c(e.options,(t,i)=>(a(),l("option",{key:i,value:e.val=="id"?t.id:t.text,selected:e.val=="id"?t.id===e.selected:t.text},s(t.text),9,v))),128))],16,f)],64))}};export{V as _};
import{T as k,l as y,c as u,a as r,u as a,w as M,F as m,v as _,o as n,Z as N,b as t,f as L,n as F,r as g,t as d,d as S}from"./app-Dzc1KR6h.js";import{M as B}from"./MainLayout-C0UmO251.js";import{_ as P,a as h,b as C}from"./TextInput-DZIJ83ft.js";import"./index-BQYW0ShB.js";import{P as E}from"./PaginationLinks-DlNDkVQw.js";import"./NavLink-DwR3EIqQ.js";import"./Modal-DTNRKeJ2.js";import"./ApplicationLogo-YJ-ANCo8.js";const $={class:"px-4 py-5"},j={class:"grid grid-col-2 gap-2"},D={class:"flex justify-between"},K={class:"justify-end mb-1"},T=["disabled"],V={class:"overflow-auto rounded-lg shadow"},z={class:"w-full"},I={class:"p-3 text-sm font-semibold tracking-wide text-left table-bordered"},Z={class:"p-3 text-sm font-semibold tracking-wide text-left table-bordered"},q={class:"p-3 text-sm font-semibold tracking-wide text-left table-bordered"},A={class:"p-3 text-sm font-semibold tracking-wide text-left table-bordered"},G={class:"p-3 text-sm font-semibold tracking-wide text-left table-bordered"},H={class:"mt-4"},J={class:"flex space-x-1"},st={__name:"MeterList",setup(O){const o=k({region:"",file:""}),f=()=>{o.post(route("upload.list"),{onFinish:()=>o.reset()})},x=s=>{!s.url||s.active||b(s.url)},w=s=>{s.target.value.trim()!=""&&_.dispatch("getMethod",{url:"search-meter-list/"+s.target.value}).then(e=>{(e==null?void 0:e.status)==200?i.value=e.data:i.value=[]}).catch(e=>{console.log(e)})},i=y({});function b(s="load-meter-list"){_.dispatch("getMethod",{url:s}).then(e=>{(e==null?void 0:e.status)==200&&(i.value=e.data)}).catch(e=>{i.value=[],console.log(e)})}return b(),(s,e)=>(n(),u(m,null,[r(a(N),{title:"Meter List"}),r(B,null,{default:M(()=>{var p;return[t("div",$,[t("form",{onSubmit:L(f,["prevent"])},[t("div",j,[t("div",null,[t("div",D,[r(P,{for:"file",value:"Excel File"}),e[1]||(e[1]=t("a",{href:"/files/images/meter list.xlsx",class:"text-optimal font-bold"},"Download File",-1))]),r(h,{id:"file",type:"file",class:"mt-1 block w-full",onInput:e[0]||(e[0]=l=>a(o).file=l.target.files[0]),autofocus:""}),r(C,{class:"mt-2",message:a(o).errors.file},null,8,["message"])]),t("div",K,[t("button",{onClick:f,class:F([{"opacity-25":a(o).processing},"bg-optimal text-white px-4 py-2 rounded mr-2"]),disabled:a(o).processing},"Submit",10,T)])])],32),t("div",V,[r(h,{id:"longitude",type:"text",class:"mt-1 block w-full",onKeyup:w,placeholder:"Enter Meter Number"}),t("table",z,[e[2]||(e[2]=t("thead",{class:"bg-gray-50 border-b-2 border-gray-200"},[t("tr",null,[t("th",{width:"5%",class:"p-3 text-sm font-semibold tracking-wide text-left table-bordered"},"S/N"),t("th",{class:"p-3 text-sm font-semibold tracking-wide text-left table-bordered"},"Meter Number"),t("th",{class:"p-3 text-sm font-semibold tracking-wide text-left table-bordered"},"Phase"),t("th",{class:"p-3 text-sm font-semibold tracking-wide text-left table-bordered"},"Type"),t("th",{class:"p-3 text-sm font-semibold tracking-wide text-left table-bordered"},"Status")])],-1)),t("tbody",null,[(n(!0),u(m,null,g((p=i.value)==null?void 0:p.data,(l,c)=>(n(),u("tr",{class:"bg-white",key:c},[t("td",I,d(c+1),1),t("td",Z,d(l.meter_number),1),t("td",q,d(l.phase),1),t("td",A,d(l.type),1),t("td",G,d(l.meter_status),1)]))),128))])]),t("div",H,[t("div",J,[(n(!0),u(m,null,g(i.value.links,(l,c)=>(n(),S(E,{link:l,key:c,onNext:v=>x(v,l)},null,8,["link","onNext"]))),128))])])])])]}),_:1})],64))}};export{st as default};
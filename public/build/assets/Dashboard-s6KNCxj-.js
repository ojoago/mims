import{M as K}from"./MainLayout-Cmmk1awv.js";import{j as R,k as U,l as d,m as C,p as $,q as L,s as Z,o as w,c as x,d as H,u as G,t as J,a as g,w as Q,F as W,v as O,Z as X,b as y}from"./app-CW3dysIp.js";import"./NavLink-CClDQF10.js";import"./Modal-Bt06__4A.js";import"./TextInput-vrEPnpDg.js";import"./ApplicationLogo-BHMTuYLo.js";const P="https://www.gstatic.com/charts/loader.js";let b=null;const D=new Map;function Y(){return window.google!==void 0?Promise.resolve(window.google.charts):(b===null&&(b=new Promise(t=>{const e=document.querySelector('script[src="'.concat(P,'"]')),n=e||document.createElement("script");e||(n.src=P,n.type="text/javascript",document.head.append(n)),n.onload=()=>{window.google!==void 0&&t(window.google.charts)}})),b)}async function tt(){let t=arguments.length>0&&arguments[0]!==void 0?arguments[0]:"current",{packages:e=["corechart","controls"],language:n="en",mapsApiKey:a}=arguments.length>1?arguments[1]:void 0;const r=await Y(),l="".concat(t,"_").concat(e.join("_"),"_").concat(n);if(D.has(l))return D.get(l);const i=new Promise(s=>{r.load(t,{packages:e,language:n,mapsApiKey:a}),r.setOnLoadCallback(()=>s(window.google))});return D.set(l,i),i}function et(t,e,n){return t!==null&&e instanceof t.visualization.DataTable||t!==null&&e instanceof t.visualization.DataView?e:t!==null&&Array.isArray(e)?t.visualization.arrayToDataTable(e,n):t!==null&&e!==null&&typeof e=="object"?new t.visualization.DataTable(e):null}function V(t,e,n,a,r,l){const i=(h,v,f)=>{if(f===void 0)throw new Error("please, provide chart type property");return new v.visualization[f](h)};if(t===null)throw new Error("please, provide charts lib property");if(n===null)throw new Error("please, provide chart element property");return e=(l||i)(n,t,a),nt(t,e,r),e}function nt(t,e,n){if(n!==null)for(const[a,r]of Object.entries(n))t!==null&&e!==null&&t.visualization.events.addListener(e,a,r)}function B(t){let e=arguments.length>1&&arguments[1]!==void 0?arguments[1]:50,n;function a(){return e}return function(){for(var l=arguments.length,i=new Array(l),s=0;s<l;s++)i[s]=arguments[s];const h=this,v=function(){n=void 0,t.apply(h,i)};n!==void 0&&clearTimeout(n),n=setTimeout(v,a())}}let m=null;const N=U({name:"GChart",props:{type:{type:String,required:!0},data:{type:[Array,Object,null],default:()=>[]},isFirstRowLabels:{type:Boolean,default:!1},options:{type:Object,default:()=>({})},version:{type:String,default:"current"},settings:{type:Object,default:()=>({packages:["corechart","table"]})},events:{type:Object,default:null},createChart:{type:Function,default:void 0},resizeDebounce:{type:Number,default:200}},setup(t,e){let{emit:n}=e;const a=d(null),r=d(null);function l(){if(m===null||a.value===null)return;const i=et(m,t.data,t.isFirstRowLabels);if(i!==null){var s;(s=a.value)===null||s===void 0||s.draw(i,t.options)}}return C(()=>t.data,()=>l(),{deep:!0}),C(()=>t.options,()=>l(),{deep:!0}),C(()=>t.type,()=>{a.value=V(m,a.value,r.value,t.type,t.events,t.createChart),l()}),$(()=>{tt(t.version,t.settings).then(i=>{i!==void 0&&(m=i,a.value=V(m,a.value,r.value,t.type,t.events,t.createChart),n("ready",a.value,i),l())}),t.resizeDebounce>0&&window.addEventListener("resize",B(l,t.resizeDebounce))}),L(()=>{a.value!==null&&typeof a.value.clearChart=="function"&&a.value.clearChart(),t.resizeDebounce>0&&window.removeEventListener("resize",B(l,t.resizeDebounce))}),()=>Z("div",{ref:r},[])}}),q=R({});function at(){q.component("GChart",N)}const ot={version:"1.1.0",install:at};let k=null;typeof window<"u"&&(k=window.Vue);k!=null&&q.use(ot);const lt={key:1,class:"text-center p-4 mt-4"},_={__name:"ChartComponent",props:{length:Number,chart:String,data:Array,options:Array},setup(t){return(e,n)=>{var a;return w(),x("div",null,[t.length>1?(w(),H(G(N),{key:0,type:t.chart,data:t.data,options:t.options,style:{width:"100%",height:"auto"}},null,8,["type","data","options"])):(w(),x("span",lt,J((a=t.options)==null?void 0:a.title)+", No Data loaded",1))])}}},it={class:"py-1"},rt={class:"px-2"},st={class:"bg-[#f1f1f1] overflow-hidden shadow-sm sm:rounded-lg"},ut={class:"flex flex-col md:flex-row"},gt={__name:"Dashboard",setup(t){const e=d({options:{legend:{position:"bottom",alignment:"start"},backgroundColor:{fill:"#f1f1f1",fillOpacity:.8},title:"Meters",vAxis:{minValue:0}},data:[]}),n=d({options:{legend:{position:"bottom",alignment:"start"},backgroundColor:{fill:"#f1f1f1",fillOpacity:.8},title:"Daily Installations"},data:[]}),a=d({options:{legend:{position:"bottom",alignment:"start"},backgroundColor:{fill:"#f1f1f1",fillOpacity:.8},title:"Monthly Installations",vAxis:{minValue:0}},data:[]}),r=["","In store","Taken out for Installation","Installed","Faulty"],l=d(0),i=d({});function s(f="meter-summary"){O.dispatch("getMethod",{url:f}).then(o=>{(o==null?void 0:o.status)==200&&(i.value=o.data,e.value.data.push(["Status","total"]),i.value.forEach(c=>{l.value+=c.count,e.value.data.push([r[c==null?void 0:c.status],c.count])}),e.value.options.title="Meters, Total: "+l.value)}).catch(o=>{console.log(o)})}const h=d({});function v(f="meter-installation"){O.dispatch("getMethod",{url:f}).then(o=>{var c,p;(o==null?void 0:o.status)==200&&(h.value=o.data,a.value.data.push(["Month","total"]),(c=o==null?void 0:o.data)==null||c.monthly.forEach(u=>{a.value.data.push([u==null?void 0:u.month,u.count])}),n.value.data.push(["Day","total"]),(p=o==null?void 0:o.data)==null||p.daily.forEach(u=>{n.value.data.push([u==null?void 0:u.doi,u.count])}))}).catch(o=>{console.log(o)})}return s(),v(),(f,o)=>(w(),x(W,null,[g(G(X),{title:"Dashboard"}),g(K,null,{default:Q(()=>{var c,p,u,z,M,A,S,j,E,F,T,I;return[y("div",it,[y("div",rt,[y("div",st,[y("div",ut,[g(_,{length:(p=(c=a.value)==null?void 0:c.data)==null?void 0:p.length,chart:"PieChart",data:(u=a.value)==null?void 0:u.data,options:(z=a.value)==null?void 0:z.options},null,8,["length","data","options"]),g(_,{length:(A=(M=e.value)==null?void 0:M.data)==null?void 0:A.length,chart:"PieChart",data:(S=e.value)==null?void 0:S.data,options:(j=e.value)==null?void 0:j.options},null,8,["length","data","options"])]),g(_,{length:(F=(E=n.value)==null?void 0:E.data)==null?void 0:F.length,chart:"ColumnChart",data:(T=n.value)==null?void 0:T.data,options:(I=n.value)==null?void 0:I.options},null,8,["length","data","options"])])])])]}),_:1})],64))}};export{gt as default};
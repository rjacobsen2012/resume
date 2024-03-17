import{_ as B}from"./AppLayout-DgUK4KnZ.js";import{s as L,d as i,p as T,B as V,o as f,c as g,w as o,b as t,f as l,a as c,u as a,a3 as r,h as A,a4 as D,O as d,a2 as R}from"./app-PHXSfIzS.js";import{_ as u}from"./CustomButton-CiERMIHg.js";import"./ThemeSwitchButton-DM7kCwpu.js";const E={class:"py-12"},I={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},O={class:"bg-gray-400 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg"},S={class:"flex items-center justify-end gap-2"},Y={__name:"Index",props:{status:{type:String,default:null}},setup(U){const h="https://user-resume.test";L(()=>{y()});const m=i(!0),b=i(0),v=T({current_page:1,pagesize:10,sort_column:"id",sort_direction:"asc"}),p=i(null),y=async()=>{try{m.value=!0;const s=await(await fetch(`${h}/permissions?${new URLSearchParams(v)}`)).json();p.value=s==null?void 0:s.data,b.value=s==null?void 0:s.recordsTotal}catch{}m.value=!1},w=()=>{d.get(route("permission.create"))},x=e=>{d.get(route("permission.edit",[e]))},k=V(),_=i(null),C=()=>{axios.delete(route("permission.destroy",[_.value])).then(e=>{P(e.data.status),d.get(route("permission.index"))})},P=e=>{R.useToast().success(e)},$=e=>{_.value=e,k.require({message:"Are you sure you want to delete the permission?",header:"Remove Permission",icon:"icon-delete",rejectLabel:"No",rejectClass:"btn-success",acceptLabel:"Yes",acceptClass:"btn-danger",accept:C})},N=[{name:"Permissions",active:!0}];return(e,s)=>(f(),g(B,{title:"Permissions",links:N},{"right-links":o(()=>[t(u,{type:"button",class:"btn-success",onClick:w},{default:o(()=>[l(" Add Permission ")]),_:1})]),default:o(()=>[c("div",E,[c("div",I,[c("div",O,[t(a(D),{value:p.value,stripedRows:"",paginator:"",rows:10,"rows-per-page-options":[10,20,50],"table-style":"min-width: 50rem"},{default:o(()=>[t(a(r),{field:"id",sortable:"",header:"Id"}),t(a(r),{field:"name",sortable:"",header:"Name"}),t(a(r),{field:"guard_name",sortable:"",header:"Guard"}),t(a(r),{field:"created_at",sortable:"",header:"Created"}),t(a(r),{field:"permission_id"},{body:o(({data:n})=>[c("div",S,[t(u,{type:"button",class:"btn-primary",onClick:j=>x(n.id)},{default:o(()=>[l("Edit")]),_:2},1032,["onClick"]),!n.has_users&&!n.belongs_to_role?(f(),g(u,{key:0,type:"button",class:"btn-danger",onClick:j=>$(n.id)},{default:o(()=>[l("Delete")]),_:2},1032,["onClick"])):A("",!0)])]),_:1})]),_:1},8,["value"])])])])]),_:1}))}};export{Y as default};

import{_ as b}from"./FormSection-LaCNCDrJ.js";import{_ as i}from"./InputLabel-Bk0-kVUc.js";import{_ as u,a as c}from"./TextInput-BUlhIkQM.js";import{T as g,o as V,c as U,w as l,f as n,a as d,b as a,u as s,n as v,O as x}from"./app-PHXSfIzS.js";import{_ as y}from"./CustomButton-CiERMIHg.js";import{_ as k}from"./PrimaryButton-CyD5auVm.js";import{f as S,a as $}from"./flash-4uJf4MxV.js";import"./SectionTitle-DGa_kosJ.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const w={class:"col-span-6 sm:col-span-4"},N={class:"col-span-6 sm:col-span-4"},B={class:"col-span-6 sm:col-span-4"},D={__name:"EditUserForm",props:{user:Object,status:{type:String,default:null}},setup(p){const m=p,e=g({_method:"PUT",first_name:m.user.first_name,last_name:m.user.last_name,email:m.user.email}),_=()=>{x.get(route("user.index"))},f=()=>{e.put(route("user.update",[m.user.id]),{errorBag:"updateUser",preserveScroll:!0,onSuccess:r=>S(r.props.status),onError:r=>$(r[Object.keys(r)[0]])})};return(r,t)=>(V(),U(b,{onSubmitted:f},{title:l(()=>[n(" User Details ")]),description:l(()=>[n(" Update the user data. ")]),form:l(()=>[d("div",w,[a(i,{for:"first_name",value:"First Name"}),a(u,{id:"first_name",modelValue:s(e).first_name,"onUpdate:modelValue":t[0]||(t[0]=o=>s(e).first_name=o),type:"text",class:"mt-1 block w-full",required:"",autocomplete:"first_name"},null,8,["modelValue"]),a(c,{message:s(e).errors.first_name,class:"mt-2"},null,8,["message"])]),d("div",N,[a(i,{for:"last_name",value:"Last Name"}),a(u,{id:"last_name",modelValue:s(e).last_name,"onUpdate:modelValue":t[1]||(t[1]=o=>s(e).last_name=o),type:"text",class:"mt-1 block w-full",required:"",autocomplete:"last_name"},null,8,["modelValue"]),a(c,{message:s(e).errors.last_name,class:"mt-2"},null,8,["message"])]),d("div",B,[a(i,{for:"email",value:"Email"}),a(u,{id:"email",modelValue:s(e).email,"onUpdate:modelValue":t[2]||(t[2]=o=>s(e).email=o),type:"text",class:"mt-1 block w-full",required:"",autocomplete:"email"},null,8,["modelValue"]),a(c,{message:s(e).errors.email,class:"mt-2"},null,8,["message"])])]),actions:l(()=>[a(y,{type:"button",class:"btn-danger",onClick:_,disabled:s(e).processing},{default:l(()=>[n(" Cancel ")]),_:1},8,["disabled"]),a(k,{class:v([[s(e).processing?"opacity-25":"","ms-2"],"btn-primary"]),disabled:s(e).processing},{default:l(()=>[n(" Save ")]),_:1},8,["class","disabled"])]),_:1}))}};export{D as default};

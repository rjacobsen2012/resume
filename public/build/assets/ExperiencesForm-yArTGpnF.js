import{T as d,Q as p,o as r,c as s,w as t,f as o,a as x,e as f,g as k,F as v,h as w,b}from"./app-PHXSfIzS.js";import{_ as h}from"./PlainSection-DIDIUZm-.js";import n from"./Experience-mD8mn6ds.js";import"./SectionTitle-DGa_kosJ.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./flash-4uJf4MxV.js";import"./CustomButton-CiERMIHg.js";import"./TextInput-BUlhIkQM.js";import"./InputLabel-Bk0-kVUc.js";import"./Checkbox-BTPjpLH2.js";import"./textarea.esm-BaoGR2Vm.js";const T={__name:"ExperiencesForm",props:{resume:[Array,Object],newModel:[Array,Object,null]},emits:["updated","errors"],setup(e,{emit:c}){const i=c;d({experiences:p().props.resume.experiences});const m=a=>{i("updated",a)};return(a,y)=>(r(),s(h,null,{title:t(()=>[o(" Work Experience ")]),description:t(()=>[o(" Current and past work experience. ")]),content:t(()=>[x("div",null,[e.resume.experiences.length>0?(r(!0),f(v,{key:0},k(e.resume.experiences,(u,l)=>(r(),s(n,{key:u.id,resume:e.resume,"model-value":e.resume.experiences[l],class:"mb-12",onUpdated:m},null,8,["resume","model-value"]))),128)):w("",!0),b(n,{resume:e.resume,"model-value":e.newModel,onUpdated:m},null,8,["resume","model-value"])])]),_:1}))}};export{T as default};

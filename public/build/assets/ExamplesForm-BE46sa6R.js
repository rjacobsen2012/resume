import{T as x,Q as g,o as r,c as f,w as a,f as o,a as s,e as d,g as h,b as l,F as k,h as v}from"./app-PHXSfIzS.js";import{_ as y}from"./PlainSection-DIDIUZm-.js";import i from"./Example-CeV32uEy.js";import"./SectionTitle-DGa_kosJ.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./flash-4uJf4MxV.js";import"./CustomButton-CiERMIHg.js";import"./TextInput-BUlhIkQM.js";import"./InputLabel-Bk0-kVUc.js";const _={class:"grid grid-cols-1 gap-6"},b={class:"px-4 py-3 dark:bg-gray-800 sm:p-6 shadow sm:rounded-md"},w={class:"grid grid-cols-1 gap-6"},T={__name:"ExamplesForm",props:{resume:[Array,Object],newModel:[Array,Object,null]},emits:["updated","errors"],setup(e,{emit:n}){const u=n;x({examples:g().props.resume.examples});const t=m=>{u("updated",m)};return(m,B)=>(r(),f(y,null,{title:a(()=>[o(" Work Examples ")]),description:a(()=>[o(" Work examples of past employers or businesses. ")]),content:a(()=>[s("div",null,[e.resume.examples.length>0?(r(!0),d(k,{key:0},h(e.resume.examples,(c,p)=>(r(),d("div",{key:c.id,class:"px-4 py-3 dark:bg-gray-800 sm:p-6 shadow sm:rounded-md mb-16"},[s("div",_,[l(i,{resume:e.resume,"model-value":e.resume.examples[p],onUpdated:t},null,8,["resume","model-value"])])]))),128)):v("",!0),s("div",b,[s("div",w,[l(i,{resume:e.resume,"model-value":e.newModel,onUpdated:t},null,8,["resume","model-value"])])])])]),_:1}))}};export{T as default};

import{_}from"./AppLayout-DfNNT7-T.js";import{_ as x}from"./ALink-CclhdxAk.js";import b from"./ResumeTileProfile-DwT3Ts7z.js";import{o as r,e as l,a as s,h as v,t as a,b as m,w as f,d as u,c as d,g as y,n as w,F as j}from"./app-ZUYzwkD6.js";import"./ThemeSwitchButton--7_gOnxM.js";const p={class:"max-w-sm overflow-hidden rounded-xl shadow resume-card-tile']"},k={class:"px-4 py-4"},$={class:"flex flex-row justify-start items-end"},B={key:0},C=["src","alt"],O={class:"ps-2"},N={class:"font-bold text-xl"},V={class:"font-bold text-md text-gray-600 text-nowrap"},A={class:"font-bold text-sm text-nowrap"},F={class:"font-bold text-sm"},H={class:"flex flex-row justify-between pt-2"},M={class:"flex flex-row justify-center ms-1 me-2"},R={class:"flex flex-row justify-end"},S=s("i",{class:"fa fa-external-link-alt"},null,-1),z={__name:"ResumeTileCard",props:{resume:[Array,Object]},setup(e){return(o,n)=>(r(),l("div",p,[s("div",k,[s("div",$,[e.resume.user.gravatar?(r(),l("div",B,[s("img",{src:e.resume.user.gravatar,alt:e.resume.name,class:"rounded-full"},null,8,C)])):v("",!0),s("div",O,[s("div",N,a(e.resume.name),1),s("div",V,a(e.resume.title),1),s("div",A,a(e.resume.city)+", "+a(e.resume.state),1),s("div",F,a(e.resume.country),1)])]),s("div",H,[s("div",M,[m(b,{resume:e.resume},null,8,["resume"])]),s("div",R,[m(x,{href:o.route("resume.show",[e.resume.id]),title:`${e.resume.name}' Resume`},{default:f(()=>[S]),_:1},8,["href","title"])])])])]))}},D={class:"flex flex-row justify-start flex-wrap gap-4 mt-4 mx-4"},K={__name:"Home",props:{resumes:[Array,Object]},setup(e){const o=e,n=u([]);for(let t=0;t<o.resumes.length;t++)n.value.push(i);const h=t=>Object.entries(t)[Math.floor(Math.random()*Object.entries(t).length)][1];function i(){return h(g.value)}const g=u({blue:"bg-blue-300",amber:"bg-amber-300",cyan:"bg-cyan-300",emerald:"bg-emerald-300",fuchsia:"bg-fuchsia-300",green:"bg-green-300",indigo:"bg-indigo-300",lime:"bg-lime-300",orange:"bg-orange-300",pink:"bg-pink-300",purple:"bg-purple-300"});return(t,E)=>(r(),d(_,{title:"Home"},{default:f(()=>[s("div",D,[(r(!0),l(j,null,y(e.resumes,(c,L)=>(r(),d(z,{key:c.id,resume:c,class:w(i())},null,8,["resume","class"]))),128))])]),_:1}))}};export{K as default};

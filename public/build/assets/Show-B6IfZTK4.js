import{_ as p}from"./AppLayout-DgUK4KnZ.js";import c from"./DeleteUserForm-Cyi02rLz.js";import l from"./LogoutOtherBrowserSessionsForm-T1r2-kc1.js";import{S as s}from"./SectionBorder-AK5H-1Yq.js";import u from"./TwoFactorAuthenticationForm-r0n8SzRC.js";import f from"./UpdatePasswordForm-JF8-KYra.js";import _ from"./UpdateProfileInformationForm-DVJSoq05.js";import{o,c as d,w as h,a as m,e as r,b as t,h as a,F as $}from"./app-PHXSfIzS.js";import"./ThemeSwitchButton-DM7kCwpu.js";import"./DialogModal-CFZw51Fn.js";import"./SectionTitle-DGa_kosJ.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./DangerButton-B-mybUQU.js";import"./TextInput-BUlhIkQM.js";import"./SecondaryButton-CMEDJISD.js";import"./ActionMessage-ielUl1Z0.js";import"./PrimaryButton-CyD5auVm.js";import"./InputLabel-Bk0-kVUc.js";import"./FormSection-LaCNCDrJ.js";const g={class:"max-w-7xl mx-auto py-10 sm:px-6 lg:px-8"},k={key:0},w={key:1},v={key:2},z={__name:"Show",props:{confirmsTwoFactorAuthentication:Boolean,sessions:Array},setup(i){const n=[{name:"Profile",active:!0}];return(e,y)=>(o(),d(p,{title:"Profile",links:n},{default:h(()=>[m("div",null,[m("div",g,[e.$page.props.jetstream.canUpdateProfileInformation?(o(),r("div",k,[t(_,{user:e.$page.props.auth.user},null,8,["user"]),t(s)])):a("",!0),e.$page.props.jetstream.canUpdatePassword?(o(),r("div",w,[t(f,{class:"mt-10 sm:mt-0"}),t(s)])):a("",!0),e.$page.props.jetstream.canManageTwoFactorAuthentication?(o(),r("div",v,[t(u,{"requires-confirmation":i.confirmsTwoFactorAuthentication,class:"mt-10 sm:mt-0"},null,8,["requires-confirmation"]),t(s)])):a("",!0),t(l,{sessions:i.sessions,class:"mt-10 sm:mt-0"},null,8,["sessions"]),e.$page.props.jetstream.hasAccountDeletionFeatures?(o(),r($,{key:3},[t(s),t(c,{class:"mt-10 sm:mt-0"})],64)):a("",!0)])])]),_:1}))}};export{z as default};

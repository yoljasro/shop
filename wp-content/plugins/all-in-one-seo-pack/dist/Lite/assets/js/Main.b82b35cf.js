import{E as p}from"./links.813d802e.js";import{a as i}from"./addons.6651d172.js";import{R as m,a as u}from"./RequiresUpdate.cb97a4e5.js";import{C as _}from"./Index.5b098c62.js";import{a as l}from"./Header.12e3b412.js";import{o,c as s,y as d,D as f,m as g,l as h,x}from"./vue.esm-bundler.7598fd57.js";import{_ as n}from"./_plugin-vue_export-helper.c114f5e4.js";import k from"./Overview.df4fde33.js";import"./default-i18n.3881921e.js";import"./isArrayLikeObject.5519e7e6.js";import"./upperFirst.67708519.js";import"./_stringToArray.4de3b1f3.js";import"./toString.8b13982a.js";import"./RequiresUpdate.19bf726d.js";import"./license.e3b96863.js";import"./allowed.ea569dbe.js";/* empty css             */import"./params.f0608262.js";import"./Ellipse.6b410f74.js";import"./Caret.13c1041f.js";import"./ScrollAndHighlight.b5ba47fd.js";import"./LogoGear.e54c732a.js";import"./Logo.f0888cfa.js";import"./Support.0e6f0669.js";import"./Tabs.c4ec03a5.js";import"./TruSeoScore.b474bf15.js";import"./Information.8ca58f92.js";import"./Slide.8d21c232.js";import"./Url.4051e9b7.js";import"./Date.17e52d00.js";import"./constants.2883a7a9.js";import"./Exclamation.3ebc8239.js";import"./Gear.e267ac3b.js";import"./AnimatedNumber.29f8f83e.js";import"./numbers.c7cb4085.js";import"./index.dfdc56df.js";import"./AddonConditions.05b9d919.js";import"./Index.bc260cfc.js";import"./Row.cd3858a9.js";import"./Blur.dfbd44b9.js";import"./Card.68c5f6b2.js";import"./Tooltip.446bcf89.js";import"./InternalOutbound.3c6ad955.js";import"./DonutChartWithLegend.48e0b578.js";import"./SeoSiteScore.f2154b15.js";import"./Row.c0dcc671.js";import"./RequiredPlans.d12c09c3.js";const v={};function $(t,e){return o(),s("div")}const A=n(v,[["render",$]]),y={};function b(t,e){return o(),s("div")}const S=n(y,[["render",b]]),R={};function T(t,e){return o(),s("div")}const w=n(R,[["render",T]]),C={};function L(t,e){return o(),s("div")}const M=n(C,[["render",L]]);const P={setup(){return{linkAssistantStore:p()}},components:{CoreMain:_,CoreProcessingPopup:l,DomainsReport:A,LinksReport:S,Overview:k,PostReport:w,Settings:M},mixins:[m,u],data(){return{strings:{pageName:this.$t.__("Link Assistant",this.$td)}}},computed:{excludedTabs(){const t=(i.isActive("aioseo-link-assistant")?this.getExcludedUpdateTabs("aioseo-link-assistant"):this.getExcludedActivationTabs("aioseo-link-assistant"))||[];return t.push("post-report"),t}},mounted(){window.aioseoBus.$on("changes-saved",()=>{this.linkAssistantStore.getMenuData()}),this.$isPro&&this.linkAssistantStore.suggestionsScan.percent!==100&&i.isActive("aioseo-link-assistant")&&!i.requiresUpgrade("aioseo-link-assistant")&&i.hasMinimumVersion("aioseo-link-assistant")&&this.linkAssistantStore.pollSuggestionsScan()}},B={class:"aioseo-link-assistant"};function D(t,e,E,U,r,a){const c=d("core-main");return o(),s("div",B,[f(c,{"page-name":r.strings.pageName,"exclude-tabs":a.excludedTabs,showTabs:t.$route.name!=="post-report"},{default:g(()=>[(o(),h(x(t.$route.name)))]),_:1},8,["page-name","exclude-tabs","showTabs"])])}const Lt=n(P,[["render",D]]);export{Lt as default};
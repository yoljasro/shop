import{g as $,m as N}from"./links.813d802e.js";import"./default-i18n.3881921e.js";import{y as i,c as h,D as t,m as a,o as p,a as c,E as _,t as n,F as A,L as V,l as B,d as f,I as E}from"./vue.esm-bundler.7598fd57.js";import{_ as L}from"./_plugin-vue_export-helper.c114f5e4.js";import{u as O,W as T}from"./Wizard.ba122561.js";import{B as F}from"./Checkbox.f60a350d.js";import{C as U}from"./ProBadge.f9c9ae69.js";import{G as q,a as I}from"./Row.cd3858a9.js";import{W as D,a as G,b as R}from"./Header.2b05b32f.js";import{W as j}from"./CloseAndExit.aad649fc.js";import{_ as H}from"./Steps.9af718dd.js";import"./isArrayLikeObject.5519e7e6.js";import"./addons.6651d172.js";import"./upperFirst.67708519.js";import"./_stringToArray.4de3b1f3.js";import"./toString.8b13982a.js";import"./Checkmark.1f5c43de.js";import"./Logo.f0888cfa.js";import"./Caret.13c1041f.js";import"./Index.39eb7788.js";const J={setup(){const{strings:e}=O();return{setupWizardStore:$(),composableStrings:e}},components:{BaseCheckbox:F,CoreProBadge:U,GridColumn:q,GridRow:I,WizardBody:D,WizardCloseAndExit:j,WizardContainer:G,WizardHeader:R,WizardSteps:H},mixins:[T],data(){return{loading:!1,stage:"features",strings:N(this.composableStrings,{whichFeatures:this.$t.__("Which SEO features do you want to enable?",this.$td),description:this.$t.__("We have already selected our recommended features based on your site category, but you can use the following features to fine-tune your site.",this.$td)})}},computed:{showPluginsAll(){return(this.setupWizardStore.features.includes("analytics")||this.setupWizardStore.features.includes("broken-link-checker")||this.setupWizardStore.features.includes("conversion-tools"))&&(this.setupWizardStore.features.includes("aioseo-eeat")||this.setupWizardStore.features.includes("aioseo-image-seo")||this.setupWizardStore.features.includes("aioseo-index-now")||this.setupWizardStore.features.includes("aioseo-link-assistant")||this.setupWizardStore.features.includes("aioseo-local-business")||this.setupWizardStore.features.includes("aioseo-news-sitemap")||this.setupWizardStore.features.includes("aioseo-redirects")||this.setupWizardStore.features.includes("aioseo-rest-api")||this.setupWizardStore.features.includes("aioseo-video-sitemap"))},showPluginsAddons(){return(!this.setupWizardStore.features.includes("analytics")||!this.setupWizardStore.features.includes("broken-link-checker")||!this.setupWizardStore.features.includes("conversion-tools"))&&(this.setupWizardStore.features.includes("aioseo-eeat")||this.setupWizardStore.features.includes("aioseo-image-seo")||this.setupWizardStore.features.includes("aioseo-index-now")||this.setupWizardStore.features.includes("aioseo-link-assistant")||this.setupWizardStore.features.includes("aioseo-local-business")||this.setupWizardStore.features.includes("aioseo-news-sitemap")||this.setupWizardStore.features.includes("aioseo-redirects")||this.setupWizardStore.features.includes("aioseo-rest-api")||this.setupWizardStore.features.includes("aioseo-video-sitemap"))},showPluginsOnly(){return(this.setupWizardStore.features.includes("analytics")||this.setupWizardStore.features.includes("broken-link-checker")||this.setupWizardStore.features.includes("conversion-tools"))&&!this.setupWizardStore.features.includes("aioseo-eeat")&&!this.setupWizardStore.features.includes("aioseo-image-seo")&&!this.setupWizardStore.features.includes("aioseo-index-now")&&!this.setupWizardStore.features.includes("aioseo-link-assistant")&&!this.setupWizardStore.features.includes("aioseo-local-business")&&!this.setupWizardStore.features.includes("aioseo-news-sitemap")&&!this.setupWizardStore.features.includes("aioseo-redirects")&&!this.setupWizardStore.features.includes("aioseo-rest-api")&&!this.setupWizardStore.features.includes("aioseo-video-sitemap")},getPluginsText(){return this.showPluginsOnly?this.$t.sprintf(this.$t.__("The following plugins will be installed: %1$s",this.$td),this.getPluginNames):this.showPluginsAddons?this.$t.sprintf(this.$t.__("The following %1$s addons will be installed: %2$s",this.$td),"AIOSEO",this.getPluginNames):this.showPluginsAll?this.$t.sprintf(this.$t.__("The following plugins and %1$s addons will be installed: %2$s",this.$td),"AIOSEO",this.getPluginNames):null},getPluginNames(){const e=[];this.features.forEach(r=>{this.setupWizardStore.features.includes(r.value)&&r.pluginName&&e.push(r.pluginName)});let o="";return 1<e.length?o=this.$t.sprintf(this.$t.__(" and %1$s",this.$td),e[e.length-1]):o=e[e.length-1],delete e[e.length-1],e.join(", ").replace(/(^[,\s]+)|([,\s]+$)/g,"")+o}},methods:{preventUncheck(e,o){o.required&&(e.preventDefault(),e.stopPropagation())},getValue(e){return this.setupWizardStore.features.includes(e.value)},updateValue(e,o){const u=[...this.setupWizardStore.features];if(e){u.push(o.value),this.setupWizardStore.features=u;return}const r=u.findIndex(l=>l===o.value);r!==-1&&u.splice(r,1),this.setupWizardStore.features=u},saveAndContinue(){this.loading=!0,this.setupWizardStore.saveWizard("features").then(()=>{this.$router.push(this.setupWizardStore.getNextLink)})}}},K={class:"aioseo-wizard-features"},M={class:"header"},Q={class:"description"},X={class:"settings-name"},Y={class:"name small-margin"},Z={class:"aioseo-description-text"},ee={key:0,class:"aioseo-installs-text"},se={class:"go-back"},te=c("div",{class:"spacer"},null,-1),ie={key:0,class:"plugins"};function oe(e,o,u,r,l,d){const W=i("wizard-header"),S=i("wizard-steps"),w=i("core-pro-badge"),g=i("grid-column"),k=i("base-checkbox"),v=i("grid-row"),z=i("router-link"),y=i("base-button"),b=i("wizard-body"),x=i("wizard-close-and-exit"),P=i("wizard-container");return p(),h("div",K,[t(W),t(P,null,{default:a(()=>[t(b,null,{footer:a(()=>[c("div",se,[t(z,{to:r.setupWizardStore.getPrevLink,class:"no-underline"},{default:a(()=>[_("←")]),_:1},8,["to"]),_("   "),t(z,{to:r.setupWizardStore.getPrevLink},{default:a(()=>[_(n(l.strings.goBack),1)]),_:1},8,["to"])]),te,t(y,{type:"blue",loading:l.loading,onClick:d.saveAndContinue},{default:a(()=>[_(n(l.strings.saveAndContinue)+" →",1)]),_:1},8,["loading","onClick"])]),default:a(()=>[t(S),c("div",M,n(l.strings.whichFeatures),1),c("div",Q,n(l.strings.description),1),(p(!0),h(A,null,V(e.features,(s,C)=>(p(),h("div",{key:C,class:"feature-grid small-padding medium-margin"},[t(v,null,{default:a(()=>[t(g,{xs:"11"},{default:a(()=>[c("div",X,[c("div",Y,[_(n(s.name)+" ",1),e.needsUpsell(s)?(p(),B(w,{key:0})):f("",!0)]),c("div",Z,n(s.description),1),s.installs&&d.getValue(s)?(p(),h("div",ee,n(s.installs),1)):f("",!0)])]),_:2},1024),t(g,{xs:"1"},{default:a(()=>[t(k,{round:"",class:E({"no-clicks":s.required}),type:s.required?"green":"blue",modelValue:s.required?!0:d.getValue(s),"onUpdate:modelValue":m=>d.updateValue(m,s),onClick:m=>d.preventUncheck(m,s)},null,8,["class","type","modelValue","onUpdate:modelValue","onClick"])]),_:2},1024)]),_:2},1024)]))),128))]),_:1}),d.getPluginsText?(p(),h("div",ie,n(d.getPluginsText),1)):f("",!0),t(x)]),_:1})])}const be=L(J,[["render",oe]]);export{be as default};
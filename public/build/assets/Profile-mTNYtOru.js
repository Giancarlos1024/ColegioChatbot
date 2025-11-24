import{a4 as g,a5 as y,c as f,a as c,T as h,P as d,ah as z,ai as E,bd as B,be as j,a_ as P,aM as M,aT as T,ax as Y,aY as V,af as I,_ as x,j as _,g as p,e as m,Y as k,ao as O,aF as Q,aU as w,w as b,n as F,F as L,$ as q,d as G,r as J,u as X,o as Z,b as o,f as l,h as tt,i as K}from"./app-CSI2DTQR.js";import{_ as et}from"./AppLayout.vue_vue_type_script_setup_true_lang-BX3xEzoN.js";import{s as v}from"./index-DNuzVkSD.js";import{s as at}from"./index-htXXqIqi.js";import{s as nt}from"./index-z3Yo8sjz.js";import st from"./PasswordPerdil-Bc0Bz6OM.js";import{_ as it}from"./perfil.vue_vue_type_script_setup_true_lang-Cd_spioB.js";import"./AppConfigurator.vue_vue_type_script_setup_true_lang-DpDyjPj6.js";import"./index-D_KOsQEr.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./index-DWx6GgBR.js";import"./index-CIJ9kEDP.js";import"./index-gZGFXwbj.js";import"./index-AfABolHN.js";import"./DeleteUser.vue_vue_type_script_setup_true_lang-Bi46bZd9.js";import"./index-Bd5u6C13.js";var rt=`
    .p-tabs {
        display: flex;
        flex-direction: column;
    }

    .p-tablist {
        display: flex;
        position: relative;
        overflow: hidden;
    }

    .p-tablist-viewport {
        overflow-x: auto;
        overflow-y: hidden;
        scroll-behavior: smooth;
        scrollbar-width: none;
        overscroll-behavior: contain auto;
    }

    .p-tablist-viewport::-webkit-scrollbar {
        display: none;
    }

    .p-tablist-tab-list {
        position: relative;
        display: flex;
        background: dt('tabs.tablist.background');
        border-style: solid;
        border-color: dt('tabs.tablist.border.color');
        border-width: dt('tabs.tablist.border.width');
    }

    .p-tablist-content {
        flex-grow: 1;
    }

    .p-tablist-nav-button {
        all: unset;
        position: absolute !important;
        flex-shrink: 0;
        inset-block-start: 0;
        z-index: 2;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: dt('tabs.nav.button.background');
        color: dt('tabs.nav.button.color');
        width: dt('tabs.nav.button.width');
        transition:
            color dt('tabs.transition.duration'),
            outline-color dt('tabs.transition.duration'),
            box-shadow dt('tabs.transition.duration');
        box-shadow: dt('tabs.nav.button.shadow');
        outline-color: transparent;
        cursor: pointer;
    }

    .p-tablist-nav-button:focus-visible {
        z-index: 1;
        box-shadow: dt('tabs.nav.button.focus.ring.shadow');
        outline: dt('tabs.nav.button.focus.ring.width') dt('tabs.nav.button.focus.ring.style') dt('tabs.nav.button.focus.ring.color');
        outline-offset: dt('tabs.nav.button.focus.ring.offset');
    }

    .p-tablist-nav-button:hover {
        color: dt('tabs.nav.button.hover.color');
    }

    .p-tablist-prev-button {
        inset-inline-start: 0;
    }

    .p-tablist-next-button {
        inset-inline-end: 0;
    }

    .p-tablist-prev-button:dir(rtl),
    .p-tablist-next-button:dir(rtl) {
        transform: rotate(180deg);
    }

    .p-tab {
        flex-shrink: 0;
        cursor: pointer;
        user-select: none;
        position: relative;
        border-style: solid;
        white-space: nowrap;
        gap: dt('tabs.tab.gap');
        background: dt('tabs.tab.background');
        border-width: dt('tabs.tab.border.width');
        border-color: dt('tabs.tab.border.color');
        color: dt('tabs.tab.color');
        padding: dt('tabs.tab.padding');
        font-weight: dt('tabs.tab.font.weight');
        transition:
            background dt('tabs.transition.duration'),
            border-color dt('tabs.transition.duration'),
            color dt('tabs.transition.duration'),
            outline-color dt('tabs.transition.duration'),
            box-shadow dt('tabs.transition.duration');
        margin: dt('tabs.tab.margin');
        outline-color: transparent;
    }

    .p-tab:not(.p-disabled):focus-visible {
        z-index: 1;
        box-shadow: dt('tabs.tab.focus.ring.shadow');
        outline: dt('tabs.tab.focus.ring.width') dt('tabs.tab.focus.ring.style') dt('tabs.tab.focus.ring.color');
        outline-offset: dt('tabs.tab.focus.ring.offset');
    }

    .p-tab:not(.p-tab-active):not(.p-disabled):hover {
        background: dt('tabs.tab.hover.background');
        border-color: dt('tabs.tab.hover.border.color');
        color: dt('tabs.tab.hover.color');
    }

    .p-tab-active {
        background: dt('tabs.tab.active.background');
        border-color: dt('tabs.tab.active.border.color');
        color: dt('tabs.tab.active.color');
    }

    .p-tabpanels {
        background: dt('tabs.tabpanel.background');
        color: dt('tabs.tabpanel.color');
        padding: dt('tabs.tabpanel.padding');
        outline: 0 none;
    }

    .p-tabpanel:focus-visible {
        box-shadow: dt('tabs.tabpanel.focus.ring.shadow');
        outline: dt('tabs.tabpanel.focus.ring.width') dt('tabs.tabpanel.focus.ring.style') dt('tabs.tabpanel.focus.ring.color');
        outline-offset: dt('tabs.tabpanel.focus.ring.offset');
    }

    .p-tablist-active-bar {
        z-index: 1;
        display: block;
        position: absolute;
        inset-block-end: dt('tabs.active.bar.bottom');
        height: dt('tabs.active.bar.height');
        background: dt('tabs.active.bar.background');
        transition: 250ms cubic-bezier(0.35, 0, 0.25, 1);
    }
`,ot={root:function(t){var n=t.props;return["p-tabs p-component",{"p-tabs-scrollable":n.scrollable}]}},lt=g.extend({name:"tabs",style:rt,classes:ot}),dt={name:"BaseTabs",extends:y,props:{value:{type:[String,Number],default:void 0},lazy:{type:Boolean,default:!1},scrollable:{type:Boolean,default:!1},showNavigators:{type:Boolean,default:!0},tabindex:{type:Number,default:0},selectOnFocus:{type:Boolean,default:!1}},style:lt,provide:function(){return{$pcTabs:this,$parentInstance:this}}},R={name:"Tabs",extends:dt,inheritAttrs:!1,emits:["update:value"],data:function(){return{d_value:this.value}},watch:{value:function(t){this.d_value=t}},methods:{updateValue:function(t){this.d_value!==t&&(this.d_value=t,this.$emit("update:value",t))},isVertical:function(){return this.orientation==="vertical"}}};function ct(e,t,n,s,i,a){return c(),f("div",d({class:e.cx("root")},e.ptmi("root")),[h(e.$slots,"default")],16)}R.render=ct;var ut={root:"p-tablist",content:"p-tablist-content p-tablist-viewport",tabList:"p-tablist-tab-list",activeBar:"p-tablist-active-bar",prevButton:"p-tablist-prev-button p-tablist-nav-button",nextButton:"p-tablist-next-button p-tablist-nav-button"},bt=g.extend({name:"tablist",classes:ut}),pt={name:"BaseTabList",extends:y,props:{},style:bt,provide:function(){return{$pcTabList:this,$parentInstance:this}}},D={name:"TabList",extends:pt,inheritAttrs:!1,inject:["$pcTabs"],data:function(){return{isPrevButtonEnabled:!1,isNextButtonEnabled:!0}},resizeObserver:void 0,watch:{showNavigators:function(t){t?this.bindResizeObserver():this.unbindResizeObserver()},activeValue:{flush:"post",handler:function(){this.updateInkBar()}}},mounted:function(){var t=this;setTimeout(function(){t.updateInkBar()},150),this.showNavigators&&(this.updateButtonState(),this.bindResizeObserver())},updated:function(){this.showNavigators&&this.updateButtonState()},beforeUnmount:function(){this.unbindResizeObserver()},methods:{onScroll:function(t){this.showNavigators&&this.updateButtonState(),t.preventDefault()},onPrevButtonClick:function(){var t=this.$refs.content,n=this.getVisibleButtonWidths(),s=B(t)-n,i=Math.abs(t.scrollLeft),a=s*.8,r=i-a,u=Math.max(r,0);t.scrollLeft=V(t)?-1*u:u},onNextButtonClick:function(){var t=this.$refs.content,n=this.getVisibleButtonWidths(),s=B(t)-n,i=Math.abs(t.scrollLeft),a=s*.8,r=i+a,u=t.scrollWidth-s,$=Math.min(r,u);t.scrollLeft=V(t)?-1*$:$},bindResizeObserver:function(){var t=this;this.resizeObserver=new ResizeObserver(function(){return t.updateButtonState()}),this.resizeObserver.observe(this.$refs.list)},unbindResizeObserver:function(){var t;(t=this.resizeObserver)===null||t===void 0||t.unobserve(this.$refs.list),this.resizeObserver=void 0},updateInkBar:function(){var t=this.$refs,n=t.content,s=t.inkbar,i=t.tabs;if(s){var a=P(n,'[data-pc-name="tab"][data-p-active="true"]');this.$pcTabs.isVertical()?(s.style.height=M(a)+"px",s.style.top=T(a).top-T(i).top+"px"):(s.style.width=Y(a)+"px",s.style.left=T(a).left-T(i).left+"px")}},updateButtonState:function(){var t=this.$refs,n=t.list,s=t.content,i=s.scrollTop,a=s.scrollWidth,r=s.scrollHeight,u=s.offsetWidth,$=s.offsetHeight,N=Math.abs(s.scrollLeft),S=[B(s),j(s)],H=S[0],U=S[1];this.$pcTabs.isVertical()?(this.isPrevButtonEnabled=i!==0,this.isNextButtonEnabled=n.offsetHeight>=$&&parseInt(i)!==r-U):(this.isPrevButtonEnabled=N!==0,this.isNextButtonEnabled=n.offsetWidth>=u&&parseInt(N)!==a-H)},getVisibleButtonWidths:function(){var t=this.$refs,n=t.prevButton,s=t.nextButton,i=0;return this.showNavigators&&(i=((n==null?void 0:n.offsetWidth)||0)+((s==null?void 0:s.offsetWidth)||0)),i}},computed:{templates:function(){return this.$pcTabs.$slots},activeValue:function(){return this.$pcTabs.d_value},showNavigators:function(){return this.$pcTabs.showNavigators},prevButtonAriaLabel:function(){return this.$primevue.config.locale.aria?this.$primevue.config.locale.aria.previous:void 0},nextButtonAriaLabel:function(){return this.$primevue.config.locale.aria?this.$primevue.config.locale.aria.next:void 0},dataP:function(){return E({scrollable:this.$pcTabs.scrollable})}},components:{ChevronLeftIcon:at,ChevronRightIcon:nt},directives:{ripple:z}},ft=["data-p"],ht=["aria-label","tabindex"],vt=["data-p"],mt=["aria-orientation"],gt=["aria-label","tabindex"];function yt(e,t,n,s,i,a){var r=I("ripple");return c(),f("div",d({ref:"list",class:e.cx("root"),"data-p":a.dataP},e.ptmi("root")),[a.showNavigators&&i.isPrevButtonEnabled?x((c(),f("button",d({key:0,ref:"prevButton",type:"button",class:e.cx("prevButton"),"aria-label":a.prevButtonAriaLabel,tabindex:a.$pcTabs.tabindex,onClick:t[0]||(t[0]=function(){return a.onPrevButtonClick&&a.onPrevButtonClick.apply(a,arguments)})},e.ptm("prevButton"),{"data-pc-group-section":"navigator"}),[(c(),m(k(a.templates.previcon||"ChevronLeftIcon"),d({"aria-hidden":"true"},e.ptm("prevIcon")),null,16))],16,ht)),[[r]]):_("",!0),p("div",d({ref:"content",class:e.cx("content"),onScroll:t[1]||(t[1]=function(){return a.onScroll&&a.onScroll.apply(a,arguments)}),"data-p":a.dataP},e.ptm("content")),[p("div",d({ref:"tabs",class:e.cx("tabList"),role:"tablist","aria-orientation":a.$pcTabs.orientation||"horizontal"},e.ptm("tabList")),[h(e.$slots,"default"),p("span",d({ref:"inkbar",class:e.cx("activeBar"),role:"presentation","aria-hidden":"true"},e.ptm("activeBar")),null,16)],16,mt)],16,vt),a.showNavigators&&i.isNextButtonEnabled?x((c(),f("button",d({key:1,ref:"nextButton",type:"button",class:e.cx("nextButton"),"aria-label":a.nextButtonAriaLabel,tabindex:a.$pcTabs.tabindex,onClick:t[2]||(t[2]=function(){return a.onNextButtonClick&&a.onNextButtonClick.apply(a,arguments)})},e.ptm("nextButton"),{"data-pc-group-section":"navigator"}),[(c(),m(k(a.templates.nexticon||"ChevronRightIcon"),d({"aria-hidden":"true"},e.ptm("nextIcon")),null,16))],16,gt)),[[r]]):_("",!0)],16,ft)}D.render=yt;var $t={root:function(t){var n=t.instance,s=t.props;return["p-tab",{"p-tab-active":n.active,"p-disabled":s.disabled}]}},Tt=g.extend({name:"tab",classes:$t}),wt={name:"BaseTab",extends:y,props:{value:{type:[String,Number],default:void 0},disabled:{type:Boolean,default:!1},as:{type:[String,Object],default:"BUTTON"},asChild:{type:Boolean,default:!1}},style:Tt,provide:function(){return{$pcTab:this,$parentInstance:this}}},C={name:"Tab",extends:wt,inheritAttrs:!1,inject:["$pcTabs","$pcTabList"],methods:{onFocus:function(){this.$pcTabs.selectOnFocus&&this.changeActiveValue()},onClick:function(){this.changeActiveValue()},onKeydown:function(t){switch(t.code){case"ArrowRight":this.onArrowRightKey(t);break;case"ArrowLeft":this.onArrowLeftKey(t);break;case"Home":this.onHomeKey(t);break;case"End":this.onEndKey(t);break;case"PageDown":this.onPageDownKey(t);break;case"PageUp":this.onPageUpKey(t);break;case"Enter":case"NumpadEnter":case"Space":this.onEnterKey(t);break}},onArrowRightKey:function(t){var n=this.findNextTab(t.currentTarget);n?this.changeFocusedTab(t,n):this.onHomeKey(t),t.preventDefault()},onArrowLeftKey:function(t){var n=this.findPrevTab(t.currentTarget);n?this.changeFocusedTab(t,n):this.onEndKey(t),t.preventDefault()},onHomeKey:function(t){var n=this.findFirstTab();this.changeFocusedTab(t,n),t.preventDefault()},onEndKey:function(t){var n=this.findLastTab();this.changeFocusedTab(t,n),t.preventDefault()},onPageDownKey:function(t){this.scrollInView(this.findLastTab()),t.preventDefault()},onPageUpKey:function(t){this.scrollInView(this.findFirstTab()),t.preventDefault()},onEnterKey:function(t){this.changeActiveValue()},findNextTab:function(t){var n=arguments.length>1&&arguments[1]!==void 0?arguments[1]:!1,s=n?t:t.nextElementSibling;return s?w(s,"data-p-disabled")||w(s,"data-pc-section")==="activebar"?this.findNextTab(s):P(s,'[data-pc-name="tab"]'):null},findPrevTab:function(t){var n=arguments.length>1&&arguments[1]!==void 0?arguments[1]:!1,s=n?t:t.previousElementSibling;return s?w(s,"data-p-disabled")||w(s,"data-pc-section")==="activebar"?this.findPrevTab(s):P(s,'[data-pc-name="tab"]'):null},findFirstTab:function(){return this.findNextTab(this.$pcTabList.$refs.tabs.firstElementChild,!0)},findLastTab:function(){return this.findPrevTab(this.$pcTabList.$refs.tabs.lastElementChild,!0)},changeActiveValue:function(){this.$pcTabs.updateValue(this.value)},changeFocusedTab:function(t,n){Q(n),this.scrollInView(n)},scrollInView:function(t){var n;t==null||(n=t.scrollIntoView)===null||n===void 0||n.call(t,{block:"nearest"})}},computed:{active:function(){var t;return O((t=this.$pcTabs)===null||t===void 0?void 0:t.d_value,this.value)},id:function(){var t;return"".concat((t=this.$pcTabs)===null||t===void 0?void 0:t.$id,"_tab_").concat(this.value)},ariaControls:function(){var t;return"".concat((t=this.$pcTabs)===null||t===void 0?void 0:t.$id,"_tabpanel_").concat(this.value)},attrs:function(){return d(this.asAttrs,this.a11yAttrs,this.ptmi("root",this.ptParams))},asAttrs:function(){return this.as==="BUTTON"?{type:"button",disabled:this.disabled}:void 0},a11yAttrs:function(){return{id:this.id,tabindex:this.active?this.$pcTabs.tabindex:-1,role:"tab","aria-selected":this.active,"aria-controls":this.ariaControls,"data-pc-name":"tab","data-p-disabled":this.disabled,"data-p-active":this.active,onFocus:this.onFocus,onKeydown:this.onKeydown}},ptParams:function(){return{context:{active:this.active}}},dataP:function(){return E({active:this.active})}},directives:{ripple:z}};function xt(e,t,n,s,i,a){var r=I("ripple");return e.asChild?h(e.$slots,"default",{key:1,dataP:a.dataP,class:F(e.cx("root")),active:a.active,a11yAttrs:a.a11yAttrs,onClick:a.onClick}):x((c(),m(k(e.as),d({key:0,class:e.cx("root"),"data-p":a.dataP,onClick:a.onClick},a.attrs),{default:b(function(){return[h(e.$slots,"default")]}),_:3},16,["class","data-p","onClick"])),[[r]])}C.render=xt;var kt={root:"p-tabpanels"},Bt=g.extend({name:"tabpanels",classes:kt}),Pt={name:"BaseTabPanels",extends:y,props:{},style:Bt,provide:function(){return{$pcTabPanels:this,$parentInstance:this}}},W={name:"TabPanels",extends:Pt,inheritAttrs:!1};function _t(e,t,n,s,i,a){return c(),f("div",d({class:e.cx("root"),role:"presentation"},e.ptmi("root")),[h(e.$slots,"default")],16)}W.render=_t;var Lt={root:function(t){var n=t.instance;return["p-tabpanel",{"p-tabpanel-active":n.active}]}},Ct=g.extend({name:"tabpanel",classes:Lt}),At={name:"BaseTabPanel",extends:y,props:{value:{type:[String,Number],default:void 0},as:{type:[String,Object],default:"DIV"},asChild:{type:Boolean,default:!1},header:null,headerStyle:null,headerClass:null,headerProps:null,headerActionProps:null,contentStyle:null,contentClass:null,contentProps:null,disabled:Boolean},style:Ct,provide:function(){return{$pcTabPanel:this,$parentInstance:this}}},A={name:"TabPanel",extends:At,inheritAttrs:!1,inject:["$pcTabs"],computed:{active:function(){var t;return O((t=this.$pcTabs)===null||t===void 0?void 0:t.d_value,this.value)},id:function(){var t;return"".concat((t=this.$pcTabs)===null||t===void 0?void 0:t.$id,"_tabpanel_").concat(this.value)},ariaLabelledby:function(){var t;return"".concat((t=this.$pcTabs)===null||t===void 0?void 0:t.$id,"_tab_").concat(this.value)},attrs:function(){return d(this.a11yAttrs,this.ptmi("root",this.ptParams))},a11yAttrs:function(){var t;return{id:this.id,tabindex:(t=this.$pcTabs)===null||t===void 0?void 0:t.tabindex,role:"tabpanel","aria-labelledby":this.ariaLabelledby,"data-pc-name":"tabpanel","data-p-active":this.active}},ptParams:function(){return{context:{active:this.active}}}}};function Nt(e,t,n,s,i,a){var r,u;return a.$pcTabs?(c(),f(L,{key:1},[e.asChild?h(e.$slots,"default",{key:1,class:F(e.cx("root")),active:a.active,a11yAttrs:a.a11yAttrs}):(c(),f(L,{key:0},[!((r=a.$pcTabs)!==null&&r!==void 0&&r.lazy)||a.active?x((c(),m(k(e.as),d({key:0,class:e.cx("root")},a.attrs),{default:b(function(){return[h(e.$slots,"default")]}),_:3},16,["class"])),[[q,(u=a.$pcTabs)!==null&&u!==void 0&&u.lazy?!0:a.active]]):_("",!0)],64))],64)):h(e.$slots,"default",{key:0})}A.render=Nt;const St={class:"card"},Vt={key:0,class:"rounded border border-surface-200 dark:border-surface-700 p-10 bg-surface-0 dark:bg-surface-900"},Kt={class:"flex items-center mb-8"},zt={class:"flex justify-between mt-6"},Xt=G({__name:"Profile",setup(e){const t=J(!0),n=X(),s=n.props.mustVerifyEmail??!1,i=n.props.status??null;return Z(()=>{setTimeout(()=>{t.value=!1},1e3)}),(a,r)=>(c(),m(et,null,{default:b(()=>[o(l(tt),{title:"Perfil"}),p("div",St,[t.value?(c(),f("div",Vt,[p("div",Kt,[o(l(v),{shape:"circle",size:"6rem",class:"mr-6"}),p("div",null,[o(l(v),{width:"15rem",height:"2rem",class:"mb-4"}),o(l(v),{width:"8rem",height:"1.5rem",class:"mb-2"}),o(l(v),{width:"12rem",height:"0.75rem"})])]),o(l(v),{width:"100%",height:"500px",class:"mb-8"}),p("div",zt,[o(l(v),{width:"6rem",height:"3rem"}),o(l(v),{width:"6rem",height:"3rem"})])])):(c(),f(L,{key:1},[r[2]||(r[2]=p("div",{class:"mb-6"},[p("h1",{class:"text-2xl font-semibold mb-1"},"Configuración"),p("p",{class:"py-4"},"Administra tu perfil y la configuración de tu cuenta")],-1)),o(l(R),{value:"0"},{default:b(()=>[o(l(D),null,{default:b(()=>[o(l(C),{value:"0"},{default:b(()=>[...r[0]||(r[0]=[K("Perfil",-1)])]),_:1}),o(l(C),{value:"1"},{default:b(()=>[...r[1]||(r[1]=[K("Contraseña",-1)])]),_:1})]),_:1}),o(l(W),null,{default:b(()=>[o(l(A),{value:"0"},{default:b(()=>[o(it,{mustVerifyEmail:l(s),status:l(i)},null,8,["mustVerifyEmail","status"])]),_:1}),o(l(A),{value:"1"},{default:b(()=>[o(st)]),_:1})]),_:1})]),_:1})],64))])]),_:1}))}});export{Xt as default};

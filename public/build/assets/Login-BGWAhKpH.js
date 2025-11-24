import{a4 as V,a5 as B,a6 as I,a7 as S,a8 as M,a9 as U,c as x,a,T as y,j as d,e as c,P as b,Y as j,d as z,a3 as N,r as T,b as i,g as r,f as s,h as _,w as u,i as p,t as g,a0 as k,n as h,F,k as P}from"./app-CSI2DTQR.js";import{_ as R}from"./FloatingConfigurator.vue_vue_type_script_setup_true_lang-Dx_dBgGy.js";import{s as q}from"./index-saBHE4wW.js";import{s as E}from"./index-BsSS1dRr.js";import{s as $}from"./index-CIJ9kEDP.js";import{s as L}from"./index-DWx6GgBR.js";import{s as C}from"./index-gZGFXwbj.js";import{_ as D}from"./_plugin-vue_export-helper-DlAUqK2U.js";import"./AppConfigurator.vue_vue_type_script_setup_true_lang-DpDyjPj6.js";import"./index-D_KOsQEr.js";import"./index-BwbBMxE1.js";var A=`
    .p-inlinemessage {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: dt('inlinemessage.padding');
        border-radius: dt('inlinemessage.border.radius');
        gap: dt('inlinemessage.gap');
    }

    .p-inlinemessage-text {
        font-weight: dt('inlinemessage.text.font.weight');
    }

    .p-inlinemessage-icon {
        flex-shrink: 0;
        font-size: dt('inlinemessage.icon.size');
        width: dt('inlinemessage.icon.size');
        height: dt('inlinemessage.icon.size');
    }

    .p-inlinemessage-icon-only .p-inlinemessage-text {
        visibility: hidden;
        width: 0;
    }

    .p-inlinemessage-info {
        background: dt('inlinemessage.info.background');
        border: 1px solid dt('inlinemessage.info.border.color');
        color: dt('inlinemessage.info.color');
        box-shadow: dt('inlinemessage.info.shadow');
    }

    .p-inlinemessage-info .p-inlinemessage-icon {
        color: dt('inlinemessage.info.color');
    }

    .p-inlinemessage-success {
        background: dt('inlinemessage.success.background');
        border: 1px solid dt('inlinemessage.success.border.color');
        color: dt('inlinemessage.success.color');
        box-shadow: dt('inlinemessage.success.shadow');
    }

    .p-inlinemessage-success .p-inlinemessage-icon {
        color: dt('inlinemessage.success.color');
    }

    .p-inlinemessage-warn {
        background: dt('inlinemessage.warn.background');
        border: 1px solid dt('inlinemessage.warn.border.color');
        color: dt('inlinemessage.warn.color');
        box-shadow: dt('inlinemessage.warn.shadow');
    }

    .p-inlinemessage-warn .p-inlinemessage-icon {
        color: dt('inlinemessage.warn.color');
    }

    .p-inlinemessage-error {
        background: dt('inlinemessage.error.background');
        border: 1px solid dt('inlinemessage.error.border.color');
        color: dt('inlinemessage.error.color');
        box-shadow: dt('inlinemessage.error.shadow');
    }

    .p-inlinemessage-error .p-inlinemessage-icon {
        color: dt('inlinemessage.error.color');
    }

    .p-inlinemessage-secondary {
        background: dt('inlinemessage.secondary.background');
        border: 1px solid dt('inlinemessage.secondary.border.color');
        color: dt('inlinemessage.secondary.color');
        box-shadow: dt('inlinemessage.secondary.shadow');
    }

    .p-inlinemessage-secondary .p-inlinemessage-icon {
        color: dt('inlinemessage.secondary.color');
    }

    .p-inlinemessage-contrast {
        background: dt('inlinemessage.contrast.background');
        border: 1px solid dt('inlinemessage.contrast.border.color');
        color: dt('inlinemessage.contrast.color');
        box-shadow: dt('inlinemessage.contrast.shadow');
    }

    .p-inlinemessage-contrast .p-inlinemessage-icon {
        color: dt('inlinemessage.contrast.color');
    }
`,Y={root:function(e){var o=e.props,m=e.instance;return["p-inlinemessage p-component p-inlinemessage-"+o.severity,{"p-inlinemessage-icon-only":!m.$slots.default}]},icon:function(e){var o=e.props;return["p-inlinemessage-icon",o.icon]},text:"p-inlinemessage-text"},G=V.extend({name:"inlinemessage",style:A,classes:Y}),H={name:"BaseInlineMessage",extends:B,props:{severity:{type:String,default:"error"},icon:{type:String,default:void 0}},style:G,provide:function(){return{$pcInlineMessage:this,$parentInstance:this}}},v={name:"InlineMessage",extends:H,inheritAttrs:!1,timeout:null,data:function(){return{visible:!0}},mounted:function(){var e=this;this.sticky||setTimeout(function(){e.visible=!1},this.life)},computed:{iconComponent:function(){return{info:U,success:M,warn:S,error:I}[this.severity]}}};function J(n,e,o,m,f,w){return a(),x("div",b({role:"alert","aria-live":"assertive","aria-atomic":"true",class:n.cx("root")},n.ptmi("root")),[y(n.$slots,"icon",{},function(){return[(a(),c(j(n.icon?"span":w.iconComponent),b({class:n.cx("icon")},n.ptm("icon")),null,16,["class"]))]}),n.$slots.default?(a(),x("div",b({key:0,class:n.cx("text")},n.ptm("text")),[y(n.$slots,"default")],16)):d("",!0)],16)}v.render=J;const K={class:"bg-surface-50 dark:bg-surface-950 flex items-center justify-center min-h-screen w-full px-4 sm:px-6"},O={class:"flex flex-col items-center justify-center w-full max-w-md"},Q={class:"w-full bg-surface-0 dark:bg-surface-900 rounded-3xl shadow-lg py-10 px-6 sm:py-16 sm:px-12",style:{"border-radius":"2rem"}},W={class:"flex items-center justify-between"},X={class:"flex items-center"},Z={class:"text-center mt-6 space-y-3"},ee={class:"text-xs text-surface-500 dark:text-surface-400 pt-2"},se=z({__name:"Login",props:{status:String,canResetPassword:Boolean},setup(n){const e=N({username:"",password:"",remember:!1}),o=T(""),m=()=>{o.value="",e.post(route("login"),{onFinish:()=>e.reset("password"),onError:()=>{o.value="Usuario o Contraseña incorrecto, por favor inténtelo nuevamente.",setTimeout(()=>{o.value=""},2e3)}})},f=()=>{P.get(route("register"))};return(w,t)=>(a(),x(F,null,[i(R),i(s(_),{title:"Log in"}),r("div",K,[r("div",O,[r("div",Q,[t[8]||(t[8]=r("div",{class:"text-center mb-8"},[r("h1",{class:"text-surface-900 dark:text-surface-0 text-2xl sm:text-3xl font-semibold mb-2"}," ¡Bienvenido! "),r("p",{class:"text-muted-color text-sm sm:text-base"},"Inicia sesión para continuar")],-1)),n.status?(a(),c(s(C),{key:0,severity:"success",closable:!1,class:"mb-4 text-sm sm:text-base"},{default:u(()=>[p(g(n.status),1)]),_:1})):d("",!0),r("form",{onSubmit:k(m,["prevent"]),class:"space-y-6"},[r("div",null,[t[3]||(t[3]=r("label",{for:"username",class:"block text-surface-900 dark:text-surface-0 text-base font-medium mb-1"}," Usuario ",-1)),i(s(L),{id:"username",type:"text",placeholder:"Usuario",class:h(["w-full mb-1",{"p-invalid":s(e).errors.username}]),modelValue:s(e).username,"onUpdate:modelValue":t[0]||(t[0]=l=>s(e).username=l),autofocus:"",required:"",autocomplete:"username"},null,8,["modelValue","class"]),s(e).errors.username?(a(),c(s(v),{key:0,severity:"error",class:"w-full mt-1"},{default:u(()=>[p(g(s(e).errors.username),1)]),_:1})):d("",!0)]),r("div",null,[t[4]||(t[4]=r("label",{for:"password",class:"block text-surface-900 dark:text-surface-0 text-base font-medium mb-1"}," Contraseña ",-1)),i(s(q),{id:"password",modelValue:s(e).password,"onUpdate:modelValue":t[1]||(t[1]=l=>s(e).password=l),placeholder:"Contraseña",toggleMask:!0,class:h(["w-full",{"p-invalid":s(e).errors.password}]),feedback:!1,required:"",autocomplete:"current-password",inputClass:"w-full"},null,8,["modelValue","class"]),s(e).errors.password?(a(),c(s(v),{key:0,severity:"error",class:"w-full mt-1"},{default:u(()=>[p(g(s(e).errors.password),1)]),_:1})):d("",!0)]),r("div",W,[r("div",X,[i(s(E),{modelValue:s(e).remember,"onUpdate:modelValue":t[2]||(t[2]=l=>s(e).remember=l),id:"remember",binary:"",class:"mr-2"},null,8,["modelValue"]),t[5]||(t[5]=r("label",{for:"remember",class:"text-surface-600 dark:text-surface-300 text-sm sm:text-base"}," Recordarme ",-1))])]),i(s($),{type:"submit",label:"Iniciar sesión",class:"w-full",loading:s(e).processing,disabled:s(e).processing},null,8,["loading","disabled"]),o.value?(a(),c(s(C),{key:0,severity:"error",closable:!1,class:"mb-4 text-sm sm:text-base"},{default:u(()=>[p(g(o.value),1)]),_:1})):d("",!0)],32),r("div",Z,[t[7]||(t[7]=r("div",{class:"text-sm text-surface-600 dark:text-surface-300"}," ¿No tienes una cuenta? ",-1)),i(s($),{type:"button",label:"Crear cuenta nueva",class:"p-button-outlined p-button-secondary w-full",onClick:f}),r("div",ee,[t[6]||(t[6]=r("span",null,"Para estudiantes: ",-1)),r("a",{href:"#",onClick:k(f,["prevent"]),class:"text-blue-600 hover:underline"}," Regístrate aquí ")])])])])])],64))}}),pe=D(se,[["__scopeId","data-v-372162ca"]]);export{pe as default};

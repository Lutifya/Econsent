(self.webpackChunk_N_E=self.webpackChunk_N_E||[]).push([[931],{1192:function(e,t,s){Promise.resolve().then(s.bind(s,4415))},2585:function(e,t,s){"use strict";s.d(t,{datasetQuiz:function(){return a}});var i={src:"./_next/static/media/foto1.6929af4e.png"};let a={topic:"",domandeTotali:2,linkPagina:"./articolo",immagineArticolo:i.src,datasetDomande:[{domanda:"Dove viene pescato il salome?",scelte:["NORVEGIA","ITALIA"],urlImage:i.src,descrizione:"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse tincidunt risus eget nibh laoreet, at tempor sem pellentesque. Aenean in pulvinar nisl, ac volutpat orci. Fusce dui sapien, blandit et pulvinar id, convallis vel ex. Vivamus in lacus tellus. Duis eu massa euismod, placerat nulla sagittis, tincidunt ex. Nulla pellentesque faucibus quam eu suscipit. Integer pellentesque lacus vel arcu sollicitudin, sit amet posuere nisi egestas. Donec ultrices, enim vehicula egestas egestas,",rispostaCorretta:"NORVEGIA"},{domanda:"Domanda di esempio 2",scelte:["scelta C","scelta D"],urlImage:i.src,descrizione:"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse tincidunt risus eget nibh laoreet, at tempor sem pellentesque. Aenean in pulvinar nisl, ac volutpat orci. Fusce dui sapien, blandit et pulvinar id, convallis vel ex. Vivamus in lacus tellus. Duis eu massa euismod, placerat nulla sagittis, tincidunt ex. Nulla pellentesque faucibus quam eu suscipit. Integer pellentesque lacus vel arcu sollicitudin, sit amet posuere nisi egestas. Donec ultrices, enim vehicula egestas egestas,",rispostaCorretta:"scelta C"}]}},7887:function(e,t,s){"use strict";s.d(t,{i:function(){return Front}});var i=s(7437);let Front=()=>(0,i.jsx)("div",{className:"bg-cover text-white",style:{backgroundImage:"url(".concat("./_next/static/media/sfondo.49c3f171.png",")")},children:(0,i.jsxs)("div",{className:"container py-5 text-center d-flex flex-column justify-content-center align-items-center",children:[(0,i.jsxs)("h1",{className:"display-7 font-weight-bold titolo",style:{fontSize:19},children:[(0,i.jsx)("p",{children:"Iniziative "}),"L'allevamento di salmone in Norvegia"]}),(0,i.jsx)("p",{className:"mb-0 text-white",style:{fontSize:16},children:"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse tincidunt risus eget nibh laoreet, at tempor sem pellentesque. Aenean in pulvinar nisl, ac volutpat orci. Fusce dui sapien, blandit et pulvinar id, convallis vel ex. Vivamus in lacus tellus. Duis eu massa euismod, placerat nulla sagittis, tincidunt ex. Nulla pellentesque faucibus quam eu suscipit. Integer pellentesque"})]})})},4415:function(e,t,s){"use strict";s.r(t),s.d(t,{default:function(){return Home}});var i=s(7437),a=s(2685),n=s.n(a),l=s(2265),c=s(2585);s(8420);var r={src:"./_next/static/media/corretto.9a1f98d0.png"},o={src:"./_next/static/media/sbagliato.993323e1.png"};let Quiz=()=>{let[e,t]=(0,l.useState)(0),[s,a]=(0,l.useState)(!1),[n,u]=(0,l.useState)(!1),[d,m]=(0,l.useState)(!1),[p,g]=(0,l.useState)(!1),{datasetDomande:_}=c.datasetQuiz,{domanda:v,scelte:h,urlImage:f,descrizione:x}=_[e];function isNotReachedTheEnd(){return e+1<c.datasetQuiz.domandeTotali}function clickButton(t){a(!s),t===_[e].rispostaCorretta&&u(!0),h.at(0)===t?m(!0):g(!0)}return(0,i.jsx)("div",{children:(0,i.jsxs)("div",{className:"mt-5 prompt-container",children:[(0,i.jsxs)("div",{className:"prompt-title",children:[(0,i.jsxs)("span",{className:"titoloDomanda",children:[e+1,"/",c.datasetQuiz.domandeTotali]})," ",v]}),(0,i.jsxs)("div",{className:"prompt-buttons",children:[(0,i.jsx)("div",{className:d?"prompt-clicked col-9":"col-9",onClick:()=>s?null:clickButton(h.at(0)),children:(0,i.jsx)("button",{className:"prompt-button",children:h.at(0)})},0),(0,i.jsx)("div",{className:p?"prompt-clicked col-9":"col-9",onClick:()=>s?null:clickButton(h.at(1)),children:(0,i.jsx)("button",{className:"prompt-button",children:h.at(1)})},1)]}),(0,i.jsxs)("div",{className:"prompt-corretta",children:[s&&n&&(0,i.jsxs)(i.Fragment,{children:[(0,i.jsx)("img",{src:r.src})," Risposta corretta!"]}),s&&!n&&(0,i.jsxs)(i.Fragment,{children:[(0,i.jsx)("img",{src:o.src})," Risposta sbagliata!"]})]}),s&&(0,i.jsxs)("div",{className:"row",style:{maxWidth:470},children:[(0,i.jsx)("div",{className:"col-md-6",children:(0,i.jsx)("img",{className:"prompt-image",src:f,alt:"Prompt Image"})}),(0,i.jsx)("div",{className:"col-md-6 ",children:(0,i.jsx)("p",{className:"flex-column  description",children:x})})]}),(0,i.jsxs)("div",{style:{width:"100%"},children:[isNotReachedTheEnd()&&s&&(0,i.jsx)("div",{children:(0,i.jsxs)("a",{className:"link float-right col-md-6",onClick:()=>{isNotReachedTheEnd()&&(t(e=>e+1),u(!1),a(!1),m(!1),g(!1))},children:["Prossima domanda ","-->"]})}),!isNotReachedTheEnd()&&s&&(0,i.jsx)("a",{className:"link float-right col-md-6",href:c.datasetQuiz.linkPagina,children:"Vai al link dell'articolo"})]})]})})};var u=s(7887);function Home(){return(0,i.jsxs)("main",{className:n().main,children:[(0,i.jsx)(u.i,{}),(0,i.jsx)("div",{className:n().container,children:(0,i.jsx)(Quiz,{})})]})}},8420:function(){},2685:function(e){e.exports={main:"page_main__GlU4n",description:"page_description__86bsR",code:"page_code__9lUUd",grid:"page_grid__f5Kdy",card:"page_card__QV0Om",center:"page_center__5oHG7",articolo:"page_articolo__ytvsl",logo:"page_logo__7fc9l",content:"page_content__kDoxQ",vercelLogo:"page_vercelLogo__rOY_u",rotate:"page_rotate__durgN"}},622:function(e,t,s){"use strict";/**
 * @license React
 * react-jsx-runtime.production.min.js
 *
 * Copyright (c) Meta Platforms, Inc. and affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */var i=s(2265),a=Symbol.for("react.element"),n=Symbol.for("react.fragment"),l=Object.prototype.hasOwnProperty,c=i.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED.ReactCurrentOwner,r={key:!0,ref:!0,__self:!0,__source:!0};function q(e,t,s){var i,n={},o=null,u=null;for(i in void 0!==s&&(o=""+s),void 0!==t.key&&(o=""+t.key),void 0!==t.ref&&(u=t.ref),t)l.call(t,i)&&!r.hasOwnProperty(i)&&(n[i]=t[i]);if(e&&e.defaultProps)for(i in t=e.defaultProps)void 0===n[i]&&(n[i]=t[i]);return{$$typeof:a,type:e,key:o,ref:u,props:n,_owner:c.current}}t.Fragment=n,t.jsx=q,t.jsxs=q},7437:function(e,t,s){"use strict";e.exports=s(622)}},function(e){e.O(0,[971,472,744],function(){return e(e.s=1192)}),_N_E=e.O()}]);
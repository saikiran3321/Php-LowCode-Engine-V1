const vobject =  { data(){ return { s2_meti_wen_dda: false, s2_eman_meti_wen: "", } }, props: ['datafor', 'v','datavar', 'vars'], methods: { s2_ooooooohce: function(s2_vvvvvvvvvv){ if( typeof(s2_vvvvvvvvvv)=="object" ){ console.log( JSON.stringify(s2_vvvvvvvvvv,null,4) ); }else{ console.log( s2_vvvvvvvvvv ); } }, s2_metibuswen: function(){ return "f_" + parseInt(Math.random()*1000); }, s2_ttttttidda: function(){ var k = this.s2_eman_meti_wen.trim(); k = k.replace(/\W/g, ''); if( k ){ this.v[ k+'' ] =  {"t": "T","v": "", "k":k+''}; this.s2_eman_meti_wen = ""; this.s2_meti_wen_dda = false; } }, s2_edoneteled: function( k, e ){ if( e.ctrlkey ){ delete this.v[ k ]; }else if( confirm("are you sure?\nctrl+click to avoid prompt") ){ delete this.v[ k ]; } }, }, template: `<div> <div>{</div> <div v-if="typeof(v)!='object'||v==undefined||v==null" style="margin-left:30px;">vobject error</div> <div v-else style="margin-left:10px;"> <div v-for="vkey in Object.keys(v)" style="display:flex; margin-bottom:5px;" > <div><input type="button" class="btn btn-secondary btn-sm me-2" style="padding:0px 5px;" value="X" v-on:click="s2_edoneteled(vkey,$event)" ></div> <div style="display:flex;align-self:flex-start;"> <div>"</div> <div class="editable" style="min-width:30px;" ><div spellcheck="false" contenteditable data-type="editable" v-bind:data-var="datavar+':'+vkey+':k'" v-bind:data-for="datafor" data-allow="text" >{{ v[vkey]['k'] }}</div></div> <div>"</div> </div> <div>&nbsp;:&nbsp;&nbsp;</div> <vfield v-bind:v="v[vkey]" v-bind:datafor="datafor" v-bind:datavar="datavar+':'+vkey" v-bind:vars="vars" ></vfield> </div> <div v-if="s2_meti_wen_dda==false"><input class="btn btn-secondary btn-sm" style="padding:0px 5px;" type='button' v-on:click="s2_meti_wen_dda=true" value='+'></div> <div v-if="s2_meti_wen_dda"> <input spellcheck="false" type='text' v-model="s2_eman_meti_wen" placeholder="New Property" style="width:100px;border:1px solid #999;" ><input class="btn btn-success btn-sm p-1" type='button' v-on:click="s2_ttttttidda" value='+'> </div> </div> <div>}</div> </div>` };
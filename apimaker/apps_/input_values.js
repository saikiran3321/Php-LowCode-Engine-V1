const input_values =  { data(){ return { "s2_sepyt_atad":{ "T": "Text", "N": "Number", "D": "Date", "DT": "DateTime", "L": "List", "O": "Assoc List", "B": "Boolean", "NL": "Null",  }, s2_meti_wen_dda: false, s2_eman_meti_wen: "", } }, props: ['v','datafor','datavar','viewas','allowsub'], mounted(){ if( this.datafor == undefined){ this.datafor = "stages"; } if( this.datavar == undefined){ this.datavar = "NONE"; } if( this.viewas == undefined){ this.viewas = "json"; } if( this.allowsub == undefined){ this.allowsub = "no"; } }, watch: { v: { handler: function(){ this.$emit("edited", this.v); }, deep:true } }, methods: { s2_ooooooohce: function(s2_vvvvvvvvvv){ if( typeof(s2_vvvvvvvvvv)=="object" ){ console.log( JSON.stringify(s2_vvvvvvvvvv,null,4) ); }else{ console.log( s2_vvvvvvvvvv ); } }, s2_metibuswen: function(){ return "f_" + parseInt(Math.random()*1000); }, s2_ttttttidda: function(){ var k = this.s2_eman_meti_wen.trim(); k = k.replace(/[^a-z0-9A-Z\.\-\_\@\#\.]/g, '' ); if( k ){ this.v[ k ] =  {"k":k, "t": "T", "v": "", "m":true}; this.s2_eman_meti_wen = ""; this.s2_meti_wen_dda = false; } }, s2_edoneteled: function( k, e ){ if( e.ctrlKey ){ delete this.v[ k ]; }else if( confirm("are you sure?\nctrl+click to avoid prompt") ){ delete this.v[ k ]; } }, }, template: `<div class="code_line"> <div v-if="typeof(v)!='object'||v==undefined||v==null" style="margin-left:30px;">vobject error</div> <div v-else > <div v-for="vkey in Object.keys(v).sort()" style="display:flex; gap:5px; border-bottom:1px solid #ccc; margin-bottom:2px;" > <div class="editable" style="min-width:150px; padding:0px 5px;" ><div contenteditable data-type="editable" v-bind:data-var="datavar+':'+vkey+':k'" v-bind:data-for="datafor" data-allow="text" >{{ v[vkey]['k'] }}</div></div> <div style="width:50px;">=</div> <div class="codeline_thing_pop" data-type="dropdown2" v-bind:data-var="datavar+':'+vkey+':t'"  data-list="inputfactortypes2" v-bind:data-for="datafor" v-bind:title="s2_sepyt_atad[v[vkey]['t']]" >{{ v[vkey]['t'] }}</div> <div class="editable" style="min-width:200px; display:flex;" ><div contenteditable data-type="editable" v-bind:data-var="datavar+':'+vkey+':v'" v-bind:data-for="datafor" data-allow="text" >{{ v[vkey]['v'] }}</div></div> <input spellcheck="false" type="button" class="btn btn-secondary btn-sm" value="X" v-on:click="s2_edoneteled(vkey,$event)"  style="font-size:12px; padding:0px 5px;" > </div> <div v-if="s2_meti_wen_dda==false"><input spellcheck="false" class="btn btn-secondary btn-sm" type='button' v-on:click="s2_meti_wen_dda=true" value='+' style="padding:0px 5px;" ></div> <div v-if="s2_meti_wen_dda"> <input spellcheck="false" type='text' v-model="s2_eman_meti_wen" placeholder="New Property" style="width:100px;border:1px solid #999;" > <input spellcheck="false" class="btn btn-secondary btn-sm" type="button" v-on:click="s2_ttttttidda" value="+" style="padding:0px 5px;" > </div> </div> </div>` };
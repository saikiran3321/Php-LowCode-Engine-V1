const vobject2 =  { data(){ return { s2_meti_wen_dda: false, s2_eman_meti_wen: "", } }, props: ['datafor', 'v','datavar', 'vars', 'suggest'], mounted: function(){ if( this.v == null ){ this.v = []; }else if( typeof(this.v) != "object" || "length" in this.v == false ){ this.v = []; } }, methods: { s2_ooooooohce: function(s2_vvvvvvvvvv){ if( typeof(s2_vvvvvvvvvv)=="object" ){ console.log( JSON.stringify(s2_vvvvvvvvvv,null,4) ); }else{ console.log( s2_vvvvvvvvvv ); } }, s2_ttttttidda: function(){ this.v.push({ "k":{"t": "T", "v": ""}, "v":{"t": "T", "v": ""}, }); }, s2_edoneteled: function( k, e ){ if( e.ctrlkey ){ this.v.splice(k,1); }else if( confirm("are you sure?\nctrl+click to avoid prompt") ){ this.v.splice(k,1); } }, }, template: `<div> <div>{</div> <div v-if="typeof(v)!='object'||v==undefined||v==null" style="margin-left:30px;">vobject error</div> <div v-else style="margin-left:20px;"> <div v-for="vd,vkey in v"  style="display:flex; margin-bottom:5px;"  > <div><input type="button" class="btn btn-secondary btn-sm me-2" style="padding:0px 5px;" value="X" v-on:click="s2_edoneteled(vkey,$event)" ></div> <div style="display:flex;align-self:flex-start;"> <div class="codeline_thing codeline_thing_T'"> <div class="editable" style="min-width:150px;" ><div spellcheck="false" contenteditable data-type="editable" v-bind:data-var="datavar+':'+vkey+':k:v'" v-bind:data-for="datafor" data-allow="text" >{{ vd['k']['v'] }}</div></div> </div> </div> <div>&nbsp;:&nbsp;&nbsp;</div> <inputtextbox2 v-bind:v="vd['v']" types="T,V" v-bind:datafor="datafor" v-bind:datavar="datavar+':'+vkey+':v'" v-bind:vars="vars" ></inputtextbox2> </div> <div><input class="btn btn-secondary btn-sm" style="padding:0px 5px;" type='button' v-on:click="s2_ttttttidda" value='+'></div> </div> <div>}</div> </div>` };
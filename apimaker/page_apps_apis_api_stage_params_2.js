const config_things1 = ["text", "number", "boolean", "list", "object"];
const config_things2 = ["static", "variable"];
const s2_smarap_egats_gifnoc = {
	"None": {
		"p": false,
	},
	"Let": {
		"p": {
			"lhs": "",
			"rhs": {"t":"T","v":""},
		},
	},
	"LetComponent": {
		"p": {
			"lhs": "",
			"rhs": {"t":"TH","v":{"i":{"t":"T", "v":""}, "l":{"t":"T", "v":""}},"th":"Components"},
		},
	},
	"Assign": {
		"p": {
			"lhs": {"t":"V","v":{"v":"","t":"","vs":false} },
			"rhs": {"t":"T","v":""},
		}
	},
	"Math": {
		"p": {
			"lhs": {"t":"V","v":{"v":"", "t":"v","vs":false}},
			"rhs": [
				{ "m": [ {"t":"N","v":"333", "OP":"+"}, {"t":"N","v":"333", "OP":"."} ], "OP": "." },
			],
		}
	},
	"Expression": {
		"p": {
			"lhs": {"t":"V","v":{"v":"", "t":"v","vs":false}},
			"rhs": {"t":"T","v":" ( x + y ) / ( a + b )"},
		},
		"h": "expression.html"
	},
	"Function": {
		"p": {
			"lhs": {"t":"V","v":{"v":"", "t":"v","vs":false}},
			"fn": "",
			"inputs": {},
			"self": false,
			"return": false,
		}
	},
	"FunctionCall": {
		"p": {
			"lhs": {"t":"V","v":{"v":"", "t":"v","vs":false}},
			"fn": {"t":"TH","v":{"t":"Function","i":{"t":"T","v":""},"l":{"t":"T","v":""}} },
			"self": false,
			"return": true,
		}
	},
	"If": {
		"p": {
			"cond": [{
				"lhs": {"t":"V","v":{"v":"","t":"","vs":false}},
				"op": "==",
				"rhs": {"t":"T","v":""},
			}],
			"op": "and",
		},
		"group": true,
		"end": "EndIf"
	},
	"While": {
		"p": {
			"cond": [{
				"lhs": {"t":"V","v":{"v":"","t":"","vs":false}},
				"op": "==",
				"rhs": {"t":"N","v":"1"},
			}],
			"op": "and",
			"maxloops": 100
		},
		"group": true,
		"end": "EndWhile"
	},
	"ForEach": {
		"p": {
			"var": {"t":"V", "v":{"v":"","t":""}},
			"key": "key",
			"value":"value"
		},
		"group": true,
		"end": "EndForEach"
	},
	"For": {
		"p": {
			"start": {"t":"N", "v": 0},
			"end": {"t":"N", "v": 100},
			"order": "a-z",
			"modifier": {"t":"N", "v": 1},
			"maxloops": 100,
			"as": "x",
		},
		"group": true,
		"end": "EndFor",
		"out": {"as":{"t":"T", "v":""}}
	},
	"Respond": {
		"p": {"t":"O", "v":{
			"status": {"t":"T", "v": "success", "k":"status"},
			"data": {"t":"T", "v": "All is well", "k":"data"},
		}},
		"tpl": [{"t":"i1", "m":"."}]
	},
	"RespondJSON": {
		"p": {
			"output":{"t":"O", "v":{
				"status": {"t":"T", "v": "success", "k":"status"},
				"data": {"t":"T", "v": "All is well", "k":"data"},
			}},
			"pretty":{"t":"B", "v":"false"}
		},
	},
	"RespondVar": {
		"p": {
			"output":{"t":"V","v":{"v":"","t":"","vs":false} },
		},
	},
	"RespondXML": {
		"p": {
			"output":{"t":"O", "v":{
				"status": {"t":"T", "v": "success", "k":"status"},
				"data": {"t":"T", "v": "All is well", "k":"data"},
			}},
			"pretty":{"t":"B", "v":"false"}
		},
	},
	"RenderHTML": {
		"p": {"html":{"t":"TT", "v":""},"css":{"t":"TT", "v":""}}
	},
	"HTMLComponent": {
		"p": {
			"html":{"t":"TT", "v":""},
			"css":{"t":"TT", "v":""}
		}
	},
	"AddHTML": {
		"p": {"t":"TT", "v":""}
	},
	"SetResponseStatus": {
		"p": {"status":{"t":"N", "v":"200"}},
	},
	"SetResponseHeader": {
		"p": {"Header":{"t":"T", "v":"X-Header"},"Value":{"t":"T", "v":"X-Value"}},
	},
	"SetCookie": {
		"p": {"Cookie":{"t":"T", "v":"Name"},"Value":{"t":"T", "v":"X-Value"},"Expire":{"t":"N", "v":"86400"}},
	},
	"SetLabel": {
		"p": {"t":"T", "v":""},
		"tpl": [{"t":"T", "m":"v"}]
	},
	"JumpToLabel": {
		"p": {"t":"T", "v":""},
		"tpl": [{"t":"D", "list":"lable", "m":"v"}]
	},
	"Sleep": {
		"p": {"t":"N", "v":"1"},
		"tpl": [{"t":"N", "m":"v"}]
	},
	"Log": {
		"p": {"t":"O", "v":{
			"data": {"t":"T", "v": "", "k":"status"},
		}},
	},
	"Database": {
		"p": {
			"d": {"t": "TH", "v": {"th":"DBs", "i":"", "l":""}},
			"t": {"t": "TH", "v": {"th":"Tables", "i":"", "l":""}},
			"a": {"t": "TH", "v": {"th":"Actions", "i":"", "l":""}},
			"c": [], // conditions
			"primary": {"field1": {"t": "S"}, "field2": {"t": "S"}},
			"indexes": {"index": "one", "t": "S" }
		},
	},
	"Internal-Table": {
		"p": {
			"data": {"stage":"initiate"}
		}
	},
	"Elastic-Table": {
		"p": {
			"data": {"stage":"initiate"}
		}
	},
	"MongoDb": {
		"p": {
			"data": {"stage":"initiate"}
		}
	},
	"MySql": {
		"p": {
			"data": {"stage":"initiate"}
		}
	},
	"HTTPRequest": {
		"p": {
			"data": {"stage":"initiate"}
		}
	}
};
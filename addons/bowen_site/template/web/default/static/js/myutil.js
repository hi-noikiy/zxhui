/**
 * 企业官网 we7 util的替换修改
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 10:47:08] -->
 */
var bowen = {
    editor: function(e, t, o) {
		if (!e && "" != e) return "";
		var n = "string" == typeof e ? e : e.id;
		n || (n = "editor-" + Math.random(), e.id = n);
		var a = {
			height: "200",
			dest_dir: "",
			image_limit: "1024",
			allow_upload_video: 1,
			audio_limit: "1024",
			callback: null
		};
		$.isFunction(t) && (t = {
			callback: t
		}), t = $.extend({}, a, t), window.UEDITOR_HOME_URL = window.sysinfo.siteroot + "web/resource/components/ueditor/";
		var r = function(a, r) {
				var l = {
					autoClearinitialContent: !1
					,toolbars: [
						["fullscreen", "source", "preview", "|", "bold", "italic", "underline", "strikethrough", "forecolor", "backcolor", "formatmatch", "|", "justifyleft", "justifycenter", "justifyright", "|", "insertorderedlist", "insertunorderedlist", "blockquote", "insertcode", "insertframe", "emotion", "link", "removeformat", "|", "rowspacingtop", "rowspacingbottom", "lineheight", "indent", "paragraph", "fontfamily", "fontsize", "|", "inserttable", "deletetable", "insertparagraphbeforetable", "insertrow", "deleterow", "insertcol", "deletecol", "mergecells", "mergeright", "mergedown", "splittocells", "splittorows", "splittocols", "|", "anchor", "map", "print", "drafts"]
					]
					,elementPathEnabled: !1
					,catchRemoteImageEnable: !1
					,initialFrameHeight: t.height
					,focus: !1
					,maximumWords: 9999999999999
                    ,iframeCssUrl: window.sysinfo.module.url + 'static/layui/css/layui.css?v=20180401'
                    
				};
				o && (l.toolbars = [
					["fullscreen", "source", "preview", "|", "bold", "italic", "underline", "strikethrough", "forecolor", "backcolor", "formatmatch", "|", "justifyleft", "justifycenter", "justifyright", "|", "insertorderedlist", "insertunorderedlist", "blockquote", "insertcode", "insertframe", "emotion", "link", "removeformat", "|", "rowspacingtop", "rowspacingbottom", "lineheight", "indent", "paragraph", "fontfamily", "fontsize", "|", "inserttable", "deletetable", "insertparagraphbeforetable", "insertrow", "deleterow", "insertcol", "deletecol", "mergecells", "mergeright", "mergedown", "splittocells", "splittorows", "splittocols", "|", "anchor", "map", "print", "drafts"]
				]);
				var s = {
					type: "image",
					direct: !1,
					multiple: !0,
					tabs: {
						upload: "active",
						browser: "",
						crawler: ""
					},
					path: "",
					dest_dir: t.dest_dir,
					global: !1,
					thumb: !1,
					width: 0,
					fileSizeLimit: 1024 * t.image_limit
				};
				if (a.registerUI("myinsertimage", function(e, t) {
					e.registerCommand(t, {
						execCommand: function() {
							r.show(function(t) {
                                var img_default_width = "100%";
                                if(sysinfo.bowen_site.apptheme == "bowen_help"){
                                    img_default_width = "850";
                                }
								if (0 != t.length) if (1 == t.length) e.execCommand("insertimage", {
									src: t[0].url,
									_src: t[0].attachment,
									width: img_default_width,
									alt: t[0].filename
								});
								else {
									var o = [];
									for (i in t) o.push({
										src: t[i].url,
										_src: t[i].attachment,
										width: img_default_width,
										alt: t[i].filename
									});
									e.execCommand("insertimage", o)
								}
							}, s)
						}
					});
					var o = new a.ui.Button({
						name: "插入图片",
						title: "插入图片",
						cssRules: "background-position: -726px -77px",
						onclick: function() {
							e.execCommand(t)
						}
					});
					return e.addListener("selectionchange", function() {
						var i = e.queryCommandState(t); - 1 == i ? (o.setDisabled(!0), o.setChecked(!1)) : (o.setDisabled(!1), o.setChecked(i))
					}), o
				}, 19), a.registerUI("myinsertvideo", function(e, i) {
					e.registerCommand(i, {
						execCommand: function() {
							r.show(function(t) {
								if (t) {
									var i = t.isRemote ? "iframe" : "video";
									e.execCommand("insertvideo", {
										url: t.url,
										width: 300,
										height: 200
									}, i)
								}
							}, {
								fileSizeLimit: 1024 * t.audio_limit,
								type: "video",
								allowUploadVideo: t.allow_upload_video,
								netWorkVideo: !0
							})
						}
					});
					var o = new a.ui.Button({
						name: "插入视频",
						title: "插入视频",
						cssRules: "background-position: -320px -20px",
						onclick: function() {
							e.execCommand(i)
						}
					});
					return e.addListener("selectionchange", function() {
						var t = e.queryCommandState(i); - 1 == t ? (o.setDisabled(!0), o.setChecked(!1)) : (o.setDisabled(!1), o.setChecked(t))
					}), o
				}, 20), n) {
					var d = a.getEditor(n, l);
					$("#" + n).removeClass("form-control"), $("#" + n).data("editor", d), $("#" + n).parents("form").submit(function() {
						d.queryCommandState("source") && d.execCommand("source")
					}), $.isFunction(t.callback) && t.callback(e, d)
				}
			};
		require(["ueditor", "fileUploader"], function(e, t) {
			r(e, t)
		}, function(e) {
			var t = e.requireModules && e.requireModules[0];
			"ueditor" === t && (requirejs.undef(t), requirejs.config({
				paths: {
					ueditor: window.sysinfo.siteroot + "web/resource/components/ueditor/ueditor.all.min"
				},
				shim: {
					ueditor: {
						deps: [window.sysinfo.siteroot + "web/resource/components/ueditor/third-party/zeroclipboard/ZeroClipboard.min.js", window.sysinfo.siteroot + "web/resource/components/ueditor/ueditor.config.js"],
						exports: "UE",
						init: function(e) {
							window.ZeroClipboard = e
						}
					}
				}
			}), require(["ueditor", "fileUploader"], function(e, t) {
				r(e, t)
			}))
		})
	}
 }
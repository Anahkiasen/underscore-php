({
  baseUrl: "assets/js",
  paths: {
    jquery: "../../components/jquery/jquery.min",
    marked: "../../components/marked/lib/marked",
    rainbow: "../../components/rainbow/js/rainbow.min",
    'rainbow-generic': "../../components/rainbow/js/language/generic",
    'rainbow-php': "../../components/rainbow/js/language/php",
    affix: "../../components/bootstrap/js/bootstrap-affix",
    scrollspy: "../../components/bootstrap/js/bootstrap-scrollspy",
  },
  optimize: "uglify2",
  name: "index",
  out: "assets/js/main.js"
})
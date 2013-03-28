require ['jquery', 'marked', 'rainbow', 'rainbow-generic', 'rainbow-php', 'scrollspy', 'affix'], ($, marked) ->

  # ////////////////////////////////////////////////////////////////////
  # ///////////////////////////// HELPERS //////////////////////////////
  # ////////////////////////////////////////////////////////////////////

  # Parses a file with Marked ---------------------------------------- /

  parse = (file) ->
    file = marked.lexer file
    file = marked.parser file

    return file

  # ////////////////////////////////////////////////////////////////////
  # ////////////////////////////// SETUP ///////////////////////////////
  # ////////////////////////////////////////////////////////////////////

  # Setup Affix ------------------------------------------------------ /

  $('.nav-stacked').affix
    'offset': 50

  # Load README ------------------------------------------------------ /

  $.get './underscore/README.md', (file) ->
    $('#readme').hide()
      .html(parse(file))
      .fadeIn()

    # Turn on ScrollSpy once content is loaded
    $('body').scrollspy
      'offset': 50

  # Load docs files -------------------------------------------------- /

  for page in ['Arrays', 'Number', 'Object', 'String', 'Functions', 'Parse', 'Repository']
    $.ajax
      type: 'GET'
      async: false,
      url: "./docs/#{page}.md"
      success: (file) ->

        # Parse and append file
        file = parse file
        article = $('#' + page).hide()
          .html("<h1>#{page}</h1>#{file}")
          .fadeIn()

        # Format code blocks
        $('pre code', article)
          .addClass('lang-php')

        # Format internal navigations
        $('ul', article)
          .addClass('list-unstyled')
          .find('ul')
            .addClass('breadcrumb')

  # Create dynamic navigation ---------------------------------------- /

  for title in $('a[name]')

    # Get function and class
    method = $(title).attr('name')
    typeClass = $(title).parents('article').attr('id')
    namespacedMethod = typeClass + '-' +method

    # Namespace function and add navigation element
    $('a[href=#'+method+']').attr('href', '#'+namespacedMethod)
    $(title).attr('name', namespacedMethod).attr('id', namespacedMethod)
    $('.'+typeClass).append("<li><a href='##{namespacedMethod}'>#{method}</a></li>")

  $('.nav-stacked > li').on 'activate', (li) ->
    li = $(li.target)
    if li.has('.nav-sub').length or li.text() is 'Introduction'
      $('.nav-sub').hide()
      $('.nav-sub', li).slideDown()
    else li.parent().parent().addClass('active')
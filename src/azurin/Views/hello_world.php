<!DOCTYPE HTML>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hello World! - {{ name }}</title>
  <link rel="shortcut icon" href="{{ url }}/favicon.ico" type="image/x-icon">
  <style>
    html {
      height: 100%;
    }
    * {
      margin: 0;
      padding: 0;
    }
    body {
      font: normal .80em 'trebuchet ms', arial, sans-serif;
      background: #F0EFE2;
      color: #777;
    }
    p {
      padding: 0 0 20px 0;
      line-height: 1.7em;
    }
    h1, h2, h3, h4, h5, h6 {
      font: normal 175% 'century gothic', arial, sans-serif;
      color: #43423F;
      margin: 0 0 15px 0;
      padding: 15px 0 5px 0;
    }
    #main, #logo, #site_content {
      margin-left: auto; 
      margin-right: auto;
    }
    #header {
      background: #025587;
      height: 240px;
    }
    #logo {
      width: 74%;
      position: relative;
      background: #025587;
    }
    #logo #logo_text {
      position: absolute; 
      top: 20px;
      left: 0;
    }
    #logo h1, #logo h2 {
      font: normal 300% 'century gothic', arial, sans-serif;
      border-bottom: 0;
      text-transform: none;
      margin: 0;
    }
    #logo_text h1, #logo_text h1 a, #logo_text h1 a:hover {
      padding: 22px 0 0 0;
      color: #FFF;
      letter-spacing: 0.1em;
      text-decoration: none;
    }
    #logo_text h1 a .logo_colour {
      color: #80FFFF;
    }
    #logo_text h2 {
      font-size: 100%;
      padding: 4px 0 0 0;
      color: #DDD;
    }
    #site_content {
      width: 70%;
      overflow: hidden;
      margin: 0 auto 0 auto;
      padding: 20px 24px 20px 37px;
      background: #FFF;
    } 
    #content {
      text-align: left;
      width: auto;
      padding: 0;
    }
  </style>
</head>
<body>
  <div id="main">
    <div id="header">
      <div id="logo">
        <div id="logo_text">
          <h1><a href="{{ url }}">{{ name }}<span class="logo_colour">{{ version }}</span></a></h1>
          <h2>{{ desc }}</h2>
        </div>
      </div>
    </div>
    <div id="site_content">
      <div id="content">
        <h1>Hello World!</h1>
        <p>
          Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
          Expedita, recusandae voluptates, ad quisquam delectus quos explicabo quidem 
          ratione rerum veniam laboriosam! Dignissimos natus doloribus ipsum necessitatibus culpa, 
          ad aut! At.
        </p>
        <p> &copy; {{ year }} {{ name }} </p>
      </div>
    </div>
  </div>
</body>
</html>
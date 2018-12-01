<?php

/* home.twig */
class __TwigTemplate_837d9c6b3965d582edb24958793b5909eb6e3cc85606c20d5e43cf0d27968d88 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<html>
    <head>
        <meta charset=\"utf-8\"/>
        <title>Slim 3</title>
        <link href='//fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css'>
        <link href='";
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->baseUrl(), "html", null, true);
        echo "/css/style.css' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <h1>Slim</h1>
        <div>a microframework for PHP</div>
    </body>
</html>
        
";
    }

    public function getTemplateName()
    {
        return "home.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  26 => 6,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<html>
    <head>
        <meta charset=\"utf-8\"/>
        <title>Slim 3</title>
        <link href='//fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css'>
        <link href='{{ base_url() }}/css/style.css' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <h1>Slim</h1>
        <div>a microframework for PHP</div>
    </body>
</html>
        
", "home.twig", "C:\\xampp\\htdocs\\temanlaut\\app\\templates\\home.twig");
    }
}

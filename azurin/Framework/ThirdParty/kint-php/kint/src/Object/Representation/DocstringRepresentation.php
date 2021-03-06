<?php

namespace Kint\Object\Representation;

class DocstringRepresentation extends Representation
{
    public $file;
    public $line;
    public $class;
    public $hints = array('docstring');

    public function __construct($docstring, $file, $line, $class = null)
    {
        parent::__construct('Docstring');

        $this->file = $file;
        $this->line = $line;
        $this->class = $class;
        $this->contents = $docstring;
    }

    /**
     * Returns the representation's docstring without surrounding comments.
     *
     * Note that this will not work flawlessly.
     *
     * On comments with whitespace after the stars the lines will begin with
     * whitespace, since we can't accurately guess how much of an indentation
     * is required.
     *
     * And on lines without stars on the left this may eat bullet points.
     *
     * Long story short: If you want the docstring read the contents. If you
     * absolutely must have it without comments (ie renderValueShort) this will
     * probably do.
     *
     * @return null|string Docstring with comments stripped
     */
    public function getDocstringWithoutComments()
    {
        if (!$this->contents) {
            return null;
        }

        $string = \substr($this->contents, 3, -2);
        $string = \preg_replace('/^\\s*\\*\\s*?(\\S|$)/m', '\\1', $string);

        return \trim($string);
    }
}

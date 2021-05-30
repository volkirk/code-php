<?php

class HeadScaner
{
    private $patterns = array('~<meta .*>~mui', '~<title>.*<\/title>~mui');
    private $taglist = [];
    public function __construct(string $text)
    {
        foreach ($this->patterns as $pattern) {
            preg_match_all($pattern, $text, $matches);
            $this->taglist = array_merge($this->taglist, $matches);
        }
    }
    private function recursiveScan($array)
    {
        $iterator = new RecursiveArrayIterator($array);
        while ($iterator->valid()) {
            if ($iterator->hasChildren()) {
                $this->recursiveScan(iterator_to_array($iterator->getChildren()));
            } else {
                echo htmlspecialchars($iterator->current()) . '<br>';
            }
            $iterator->next();

        }
        // while ($iterator->valid()){
        //     $length=strlen(htmlspecialchars($iterator->current()));

        // }
        // echo '<br> echo= ';
        // echo htmlspecialchars($iterator[1]);
    }
    public function getTagList()
    {
        $this->recursiveScan($this->taglist);
    }
}
$code = file_get_contents('code.html');
$scaner = new HeadScaner($code);
$result = $scaner->getTagList();





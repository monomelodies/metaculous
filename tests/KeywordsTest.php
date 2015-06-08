<?php

class KeywordsTest extends PHPUnit_Framework_TestCase
{
    public function testTop10Keywords()
    {
        $text = <<<EOT
<p>
Lorem ipsum dolor sit amet, consectetur adipiscing elit, nam rhoncus consectetur arcu non sodales - interdum et malesuada fames ac ante ipsum primis in faucibus! Cras suscipit sed risus a eleifend, donec fermentum aliquet bibendum, quisque ac finibus tellus. Sed massa urna, tristique sed sodales vitae, tempus ut nisl. Nulla interdum condimentum metus, at interdum tortor aliquam et. Morbi quis varius quam, sit amet placerat mauris. Quisque sit amet sem dictum, tincidunt sem at, semper turpis. Mauris ut nunc ante. In vehicula viverra nisl in posuere. Pellentesque quis orci vel eros euismod accumsan vitae nec risus.
</p>
<p>
Donec ornare sapien est. Phasellus dignissim ullamcorper erat, quis dictum enim. Nam in dui vel nisl rutrum pharetra at sit amet lorem. Praesent in odio ante. Sed risus libero, maximus eu molestie eget, bibendum quis nisl. Mauris efficitur turpis ut orci aliquam gravida. Duis at scelerisque urna.
</p>
<p>
Integer eget ultrices eros. In libero ligula, placerat ac ligula vitae, tincidunt euismod velit. Quisque suscipit vulputate libero nec aliquam. Fusce ut ligula tincidunt, placerat ante sed, iaculis odio. Proin at sodales eros. Nulla ultrices pulvinar mollis. Pellentesque feugiat varius tortor et egestas. Vivamus faucibus rhoncus rhoncus. Aliquam erat volutpat. Praesent vestibulum mauris sed vestibulum semper. Suspendisse ornare felis eu tristique lobortis. Duis bibendum sodales ex, consectetur porta neque malesuada et. Aliquam eros sapien, finibus vel mattis non, convallis a purus.
</p>
<p>
Nulla nibh tortor, viverra quis pretium ut, semper in lacus. Ut fermentum quam nec tortor finibus finibus. In dapibus sollicitudin lacus, quis mattis nisl semper id. Aenean vel sodales nisl. Sed tincidunt ante a felis consequat, ac faucibus lorem pretium. Maecenas at erat viverra, varius dui eget, egestas nisi. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Etiam sollicitudin nisi ut nulla mattis, at accumsan velit interdum. Suspendisse ac nisl sapien. Proin felis odio, vehicula dictum eros nec, dignissim ornare dui. Vestibulum accumsan, tortor nec mollis eleifend, ligula neque commodo tellus, a placerat sapien orci ac urna. Aliquam vitae eros et nisl euismod rhoncus nec vitae mi. Sed tortor justo, placerat ac augue vitae, porta hendrerit neque.
</p>
<p>
Nam nec turpis sed ipsum venenatis convallis id eget nunc. Nam nec mauris ac diam consequat consectetur. Morbi in dolor est. Nulla eget tortor ac tortor dignissim suscipit ac nec augue. Integer quis auctor elit, sed malesuada mi. Nunc a augue libero. Vestibulum venenatis neque enim, ut malesuada orci faucibus at. Vivamus quis viverra magna, a maximus arcu. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Etiam pellentesque felis et dolor egestas feugiat. Cras pretium cursus porta. Aenean ut quam laoreet, placerat mi auctor, varius risus. Nunc vel urna et odio cursus malesuada.</p>

EOT;
        // Extract the top 10 words:
        $parser = new Metaculous\Parser;
        $keywords = $parser->keywords($text);
        $this->assertTrue(count($keywords) <= 10);
    }
}


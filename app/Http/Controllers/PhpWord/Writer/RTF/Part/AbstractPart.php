<?php
/**
 * This file is part of PHPWord - A pure PHP library for reading and writing
 * word processing documents.
 *
 * PHPWord is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPWord/contributors.
 *
 * @see         https://github.com/PHPOffice/PHPWord
 * @copyright   2010-2018 PHPWord contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace PhpWord\Writer\RTF\Part;

use PhpWord\Escaper\Rtf;
use PhpWord\Exception\Exception;
use PhpWord\Writer\AbstractWriter;

/**
 * @since 0.11.0
 */
abstract class AbstractPart
{
    /**
     * @var \PhpWord\Writer\AbstractWriter
     */
    private $parentWriter;

    /**
     * @var \PhpWord\Escaper\EscaperInterface
     */
    protected $escaper;

    public function __construct()
    {
        $this->escaper = new Rtf();
    }

    /**
     * @return string
     */
    abstract public function write();

    /**
     * @param \PhpWord\Writer\AbstractWriter $writer
     */
    public function setParentWriter(AbstractWriter $writer = null)
    {
        $this->parentWriter = $writer;
    }

    /**
     * @return \PhpWord\Writer\AbstractWriter
     *@throws \PhpWord\Exception\Exception
     */
    public function getParentWriter()
    {
        if ($this->parentWriter !== null) {
            return $this->parentWriter;
        }
        throw new Exception('No parent WriterInterface assigned.');
    }
}

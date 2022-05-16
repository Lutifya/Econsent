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

namespace PhpWord\Writer\Word2007\Element;

use PhpWord\Element\TOC as TOCElement;
use PhpWord\Shared\XMLWriter;
use PhpWord\Style\Font;
use PhpWord\Writer\Word2007\Style\Font as FontStyleWriter;
use PhpWord\Writer\Word2007\Style\Paragraph as ParagraphStyleWriter;
use PhpWord\Writer\Word2007\Style\Tab as TabStyleWriter;

/**
 * TOC element writer
 *
 * @since 0.10.0
 */
class TOC extends AbstractElement
{
    /**
     * Write element.
     */
    public function write()
    {
        $xmlWriter = $this->getXmlWriter();
        $element = $this->getElement();
        if (!$element instanceof TOCElement) {
            return;
        }

        $titles = $element->getTitles();
        $writeFieldMark = true;

        foreach ($titles as $title) {
            $this->writeTitle($xmlWriter, $element, $title, $writeFieldMark);
            if ($writeFieldMark) {
                $writeFieldMark = false;
            }
        }

        $xmlWriter->startElement('w:p');
        $xmlWriter->startElement('w:r');
        $xmlWriter->startElement('w:fldChar');
        $xmlWriter->writeAttribute('w:fldCharType', 'end');
        $xmlWriter->endElement();
        $xmlWriter->endElement();
        $xmlWriter->endElement();
    }

    /**
     * Write title
     *
     * @param \PhpWord\Shared\XMLWriter $xmlWriter
     * @param \PhpWord\Element\TOC $element
     * @param \PhpWord\Element\Title $title
     * @param bool $writeFieldMark
     */
    private function writeTitle(XMLWriter $xmlWriter, TOCElement $element, $title, $writeFieldMark)
    {
        $tocStyle = $element->getStyleTOC();
        $fontStyle = $element->getStyleFont();
        $isObject = ($fontStyle instanceof Font) ? true : false;
        $rId = $title->getRelationId();
        $indent = ($title->getDepth() - 1) * $tocStyle->getIndent();

        $xmlWriter->startElement('w:p');

        // Write style and field mark
        $this->writeStyle($xmlWriter, $element, $indent);
        if ($writeFieldMark) {
            $this->writeFieldMark($xmlWriter, $element);
        }

        // Hyperlink
        $xmlWriter->startElement('w:hyperlink');
        $xmlWriter->writeAttribute('w:anchor', "_Toc{$rId}");
        $xmlWriter->writeAttribute('w:history', '1');

        // Title text
        $xmlWriter->startElement('w:r');
        if ($isObject) {
            $styleWriter = new FontStyleWriter($xmlWriter, $fontStyle);
            $styleWriter->write();
        }
        $xmlWriter->startElement('w:t');
        $this->writeText($title->getText());
        $xmlWriter->endElement(); // w:t
        $xmlWriter->endElement(); // w:r

        $xmlWriter->startElement('w:r');
        $xmlWriter->writeElement('w:tab', null);
        $xmlWriter->endElement();

        $xmlWriter->startElement('w:r');
        $xmlWriter->startElement('w:fldChar');
        $xmlWriter->writeAttribute('w:fldCharType', 'begin');
        $xmlWriter->endElement();
        $xmlWriter->endElement();

        $xmlWriter->startElement('w:r');
        $xmlWriter->startElement('w:instrText');
        $xmlWriter->writeAttribute('xml:space', 'preserve');
        $xmlWriter->text("PAGEREF _Toc{$rId} \h");
        $xmlWriter->endElement();
        $xmlWriter->endElement();

        $xmlWriter->startElement('w:r');
        $xmlWriter->startElement('w:fldChar');
        $xmlWriter->writeAttribute('w:fldCharType', 'end');
        $xmlWriter->endElement();
        $xmlWriter->endElement();

        $xmlWriter->endElement(); // w:hyperlink

        $xmlWriter->endElement(); // w:p
    }

    /**
     * Write style
     *
     * @param \PhpWord\Shared\XMLWriter $xmlWriter
     * @param \PhpWord\Element\TOC $element
     * @param int $indent
     */
    private function writeStyle(XMLWriter $xmlWriter, TOCElement $element, $indent)
    {
        $tocStyle = $element->getStyleTOC();
        $fontStyle = $element->getStyleFont();
        $isObject = ($fontStyle instanceof Font) ? true : false;

        $xmlWriter->startElement('w:pPr');

        // Paragraph
        if ($isObject && !is_null($fontStyle->getParagraph())) {
            $styleWriter = new ParagraphStyleWriter($xmlWriter, $fontStyle->getParagraph());
            $styleWriter->write();
        }

        // Font
        if (!empty($fontStyle) && !$isObject) {
            $xmlWriter->startElement('w:rPr');
            $xmlWriter->startElement('w:rStyle');
            $xmlWriter->writeAttribute('w:val', $fontStyle);
            $xmlWriter->endElement();
            $xmlWriter->endElement(); // w:rPr
        }

        // Tab
        $xmlWriter->startElement('w:tabs');
        $styleWriter = new TabStyleWriter($xmlWriter, $tocStyle);
        $styleWriter->write();
        $xmlWriter->endElement();

        // Indent
        if ($indent > 0) {
            $xmlWriter->startElement('w:ind');
            $xmlWriter->writeAttribute('w:left', $indent);
            $xmlWriter->endElement();
        }

        $xmlWriter->endElement(); // w:pPr
    }

    /**
     * Write TOC Field.
     *
     * @param \PhpWord\Shared\XMLWriter $xmlWriter
     * @param \PhpWord\Element\TOC $element
     */
    private function writeFieldMark(XMLWriter $xmlWriter, TOCElement $element)
    {
        $minDepth = $element->getMinDepth();
        $maxDepth = $element->getMaxDepth();

        $xmlWriter->startElement('w:r');
        $xmlWriter->startElement('w:fldChar');
        $xmlWriter->writeAttribute('w:fldCharType', 'begin');
        $xmlWriter->endElement();
        $xmlWriter->endElement();

        $xmlWriter->startElement('w:r');
        $xmlWriter->startElement('w:instrText');
        $xmlWriter->writeAttribute('xml:space', 'preserve');
        $xmlWriter->text("TOC \o {$minDepth}-{$maxDepth} \h \z \u");
        $xmlWriter->endElement();
        $xmlWriter->endElement();

        $xmlWriter->startElement('w:r');
        $xmlWriter->startElement('w:fldChar');
        $xmlWriter->writeAttribute('w:fldCharType', 'separate');
        $xmlWriter->endElement();
        $xmlWriter->endElement();
    }
}
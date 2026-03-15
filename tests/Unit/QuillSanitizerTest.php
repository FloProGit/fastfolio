<?php

namespace Tests\Unit;

use App\Domain\Shared\Helpers\QuillSanitizer;
use PHPUnit\Framework\TestCase;

class QuillSanitizerTest extends TestCase
{
    public function test_removes_ql_ui_spans(): void
    {
        $html = '<ol><li><span class="ql-ui" contenteditable="false"></span>Premier élément</li></ol>';

        $result = QuillSanitizer::clean($html);

        $this->assertStringNotContainsString('ql-ui', $result);
        $this->assertStringContainsString('Premier élément', $result);
    }

    public function test_removes_data_list_attribute(): void
    {
        $html = '<ol><li data-list="ordered">Élément</li></ol>';

        $result = QuillSanitizer::clean($html);

        $this->assertStringNotContainsString('data-list', $result);
        $this->assertStringContainsString('<li>Élément</li>', $result);
    }

    public function test_keeps_standard_html_intact(): void
    {
        $html = '<p><strong>Gras</strong> et <em>italique</em></p>';

        $result = QuillSanitizer::clean($html);

        $this->assertEquals($html, $result);
    }

    public function test_keeps_lists_structure(): void
    {
        $html = '<ol><li data-list="ordered"><span class="ql-ui" contenteditable="false"></span>Un</li><li data-list="ordered"><span class="ql-ui" contenteditable="false"></span>Deux</li></ol>';

        $result = QuillSanitizer::clean($html);

        $this->assertStringContainsString('<ol>', $result);
        $this->assertStringContainsString('<li>Un</li>', $result);
        $this->assertStringContainsString('<li>Deux</li>', $result);
    }

    public function test_keeps_links(): void
    {
        $html = '<p><a href="https://example.com">Lien</a></p>';

        $result = QuillSanitizer::clean($html);

        $this->assertEquals($html, $result);
    }

    public function test_handles_empty_string(): void
    {
        $this->assertEquals('', QuillSanitizer::clean(''));
    }

    public function test_keeps_headings(): void
    {
        $html = '<h2>Titre</h2><p>Paragraphe</p>';

        $result = QuillSanitizer::clean($html);

        $this->assertEquals($html, $result);
    }
}

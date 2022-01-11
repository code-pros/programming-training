<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2019 Marco Muths
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

use PhpDA\Reference\ValidatorInterface;
use PhpParser\Node\Name;

class UseCaseReferenceValidator implements ValidatorInterface
{
    const PACKAGE_VIOLATION = 'Violation of reference between top layers';

    const LAYER_VIOLATION = 'Violation of reference between layers';

    const USECASE_VIOLATION = 'Violation of reference between use cases';

    /** @var array */
    private $messages = [];

    /** @var array */
    private $packageReferences = [
        'Entity' => [],
        'UseCase' => ['Entity'],
    ];

    /** @var array */
    private $layerReferences = [
        'UseCase' => [],
        'DataAccess' => ['UseCase'],
    ];

    public function isValidBetween(Name $from, Name $to)
    {
        $this->messages = [];

        if ($this->isViolation($from->parts[0], $to->parts[0], $this->packageReferences)) {
            $this->messages[] = self::PACKAGE_VIOLATION;
        }

        if ($this->isCrossingUseCaseBoundary($from, $to)) {
            $this->messages[] = self::USECASE_VIOLATION;
        }

        if ($this->isCrossingLayerBoundary($from, $to)) {
            $this->messages[] = self::LAYER_VIOLATION;
        }

        return empty($this->messages);
    }

    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param string $from
     * @param string $to
     * @param array $references
     * @return bool
     */
    private function isViolation($from, $to, array $references)
    {
        if ($from == $to || !isset($references[$from])) {
            return false;
        }

        return !in_array($to, $references[$from]);
    }

    private function isCrossingUseCaseBoundary(Name $from, Name $to)
    {
        if ($from->parts[0] !== 'UseCase' || $to->parts[0] !== 'UseCase') {
            return false;
        }

        return $from->parts[1] !== $to->parts[1];
    }

    private function isCrossingLayerBoundary(Name $from, Name $to)
    {
        if ($from->parts[0] !== 'UseCase' || $to->parts[0] !== 'UseCase') {
            return false;
        }

        // ignore use case boundaries
        if ($from->parts[1] !== $to->parts[1]) {
            return false;
        }

        return $this->isViolation($from->parts[2], $to->parts[2], $this->layerReferences);
    }
}
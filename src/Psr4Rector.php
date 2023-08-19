<?php

declare(strict_types=1);

namespace SzepeViktor\Rector\Psr4;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Expr\MethodCall;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * Ez a példakód a Rector doksiból.
 */
final class Psr4Rector extends AbstractRector
{
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        // Nekünk itt a Class_::class kell.
        return [MethodCall::class];
    }

    /**
     * @param MethodCall $node - we can add "MethodCall" type here, because
     *                         only this node is in "getNodeTypes()"
     */
    public function refactor(Node $node): ?Node
    {
        // A namespace/útvonal párost bedrótozhatod, azt majd konfigurálhatóvá teszem.
        // 'WPO\\WC\\PDF_Invoices\\'  'includes/'

        // we only care about "set*" method names
        if (! $this->isName($node->name, 'set*')) {
            // return null to skip it
            return null;
        }

        $methodCallName = $this->getName($node->name);
        $newMethodCallName = preg_replace('#^set#', 'change', $methodCallName);

        $node->name = new Identifier($newMethodCallName);

        // return $node if you modified it
        return $node;
    }

    /**
     * Ezt hagyjad csak, majd kitöltöm.
     */
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Change method calls from set* to change*.', [
                new CodeSample(
                    // code before
                    '$user->setPassword("123456");',
                    // code after
                    '$user->changePassword("123456");'
                ),
            ]
        );
    }
}


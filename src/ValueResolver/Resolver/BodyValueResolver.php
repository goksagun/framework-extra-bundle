<?php

declare(strict_types=1);

namespace Goksagun\FrameworkExtraBundle\ValueResolver\Resolver;

use Goksagun\FrameworkExtraBundle\ValueResolver\Annotation\BodyValue;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;

class BodyValueResolver implements ValueResolverInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(private readonly SerializerInterface $serializer)
    {
    }

    /**
     * @inheritDoc
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if ([] === $argument->getAttributes(BodyValue::class)) {
            return [];
        }

        $type = $argument->getType();

        $this->logger->debug("The argument type: '" . $type . "'");

        $format = $request->getContentTypeFormat();

        $this->logger->debug("The request format: '" . $format . "'");

        yield $this->getData($request, $type, $format);
    }

    private function getData(Request $request, ?string $type, ?string $format): mixed
    {
        $content = $request->getContent();

        switch ($type) {
            case 'string':
                $data = $content;

                $this->logger->debug("Raw data: {0}", [json_encode(json_decode($content))]);
                break;
            case 'array':
                $data = json_decode($content, true);

                $this->logger->debug("Denormalized data: {0}", [$data]);
                break;
            default:
                $data = $this->serializer->deserialize($content, $type, $format);

                $this->logger->debug("Deserialized data: {0}", [$data]);
                break;
        }
        
        return $data;
    }
}
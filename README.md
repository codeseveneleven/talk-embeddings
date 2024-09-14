# Embeddings - the lesser known hero of AI

[Presented by Frank Berger at TYPO3 Developer Days 2024.](https://code711.de/talks/embeddings-the-lesser-known-hero-of-ai)

[Presented by Frank Berger at the PHP Conference Serbia 2024 .](https://2024.phpsrbija.rs/talk-single/9)


## Embeddings
Essentially, embeddings are points in a multi-dimensional space, represented as vectors. They encode both semantic and contextual information of a word, phrase, or text, making them highly significant in AI and language processing.

## Why use embeddings?
The key advantage is their ability to work with mathematical operations. In our examples, the cosine distance is calculated using PHP, and anything below 0.1 is considered a very close match.

## Tools used
Our examples depend heavily on OpenAI's embedding models. In particular, the 'text-embedding-ada-002' model with its 1536 dimensions normalized to unit length (ranging from 0 and 1) serves our purpose well.

Feel free to explore the code examples and learn more about embeddings.

## Notes

running redis-stack-server in docker:

```shell
docker run --name my-redis-container -p 6378:6379 -v `pwd`/dockerredisdata:/data  -d redis/redis-stack-server:latest
```

The examples expect an OpenAI key in the environment variable OPENAIKEY

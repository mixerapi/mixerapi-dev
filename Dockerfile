FROM athackst/mkdocs-simple-plugin:latest AS mkdocs

RUN pip install mkdocs-material markdown pymdown-extensions pygments markdown mkdocs-exclude

.SILENT: install test check
install:
	composer install
	for dir in plugins/*; do \
		bash -c "echo INSTALL: $$dir && cd $$dir && composer install"; \
	done
update:
	composer update
	for dir in plugins/*; do \
		bash -c "echo INSTALL: $$dir && cd $$dir && composer update"; \
	done
test:
	for dir in plugins/*; do \
		bash -c "echo TESTING: $$dir && cd $$dir && composer test"; \
	done
check:
	for dir in plugins/*; do \
		bash -c "echo CHECK: $$dir && cd $$dir && composer check"; \
	done
mkdocs-run:
	docker run --rm -it --network=host -v ${PWD}:/docs --user $(id -u):$(id -g) systematical/mixerapidocs:latest
mkdocs-build:
	docker run --rm -it --network=host -v ${PWD}:/docs --user $(id -u):$(id -g) systematical/mixerapidocs:latest mkdocs build
mkdocs-build:
	docker pull systematical/mixerapidocs:latest
	git pull
	docker run --rm --network=host -v ${PWD}:/docs --user $(id -u):$(id -g) systematical/mixerapidocs:latest mkdocs build

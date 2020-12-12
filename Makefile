.SILENT: install test check
install:
	composer install
	for dir in plugins/*; do \
		bash -c "echo INSTALL: $$dir && cd $$dir && composer install"; \
	done
test:
	for dir in plugins/*; do \
		bash -c "echo TESTING: $$dir && cd $$dir && composer test"; \
	done
check:
	for dir in plugins/*; do \
		bash -c "echo CHECK: $$dir && cd $$dir && composer check"; \
	done

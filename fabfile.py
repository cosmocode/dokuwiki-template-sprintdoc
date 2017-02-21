import os
import sys
import json
from fabric.api import run, env, cd

config = {
    'TARGET_PORT': 6589,
    'TARGET_USER': 'www-data',
}

try:
    TARGET_CONF = json.loads(os.getenv('TARGET_CONF'))
except (SyntaxError, ValueError) as e:
    print 'Could not parse configuration: %s' % e
    sys.exit(1)

BUILD_JOB_NAME = os.getenv('CI_BUILD_NAME')

if BUILD_JOB_NAME not in TARGET_CONF:
    print 'Could not find job configuration for %s' % BUILD_JOB_NAME
    sys.exit(1)
else:
    config.update(TARGET_CONF[BUILD_JOB_NAME])

BRANCH = os.getenv('CI_BUILD_REF_NAME')

if not BRANCH:
    print 'Could not get branch name from configuration: Please specify CI_BUILD_REF_NAME env var'
    sys.exit(1)

for option in ['TARGET_HOST', 'TARGET_PATH']:
    if not config.get(option):
        print 'Could not get %s from configuration!' % option
        sys.exit(1)

env.hosts = [config.get('TARGET_HOST')]
env.port = config.get('TARGET_PORT')
env.user = config.get('TARGET_USER')


def pre():
    if config.get('PRE_CMDS'):
        [run(cmd) for cmd in config.get('PRE_CMDS')]


def git_pull():
    run('git fetch --all')
    run('git checkout --force %s' % BRANCH)
    run('git reset --hard origin/%s' % BRANCH)


def post():
    if config.get('POST_CMDS'):
        [run(cmd) for cmd in config.get('POST_CMDS')]


def deploy():
    with cd(config.get('TARGET_PATH')):
        pre()
        git_pull()
        post()
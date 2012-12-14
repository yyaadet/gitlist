<?php

namespace GitList\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
<<<<<<< HEAD
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Response;
=======
>>>>>>> 44ed193402c5a25cddbc80ef0c87183111f348b4
use Symfony\Component\HttpFoundation\Request;

class CommitController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $route = $app['controllers_factory'];

        $route->get('{repo}/commits/{branch}/{file}', function($repo, $branch, $file) use ($app) {
            $repository = $app['git']->getRepository($app['git.repos'] . $repo);
<<<<<<< HEAD
            $type = $file ? "$branch -- $file" : $branch;
=======

            list($branch, $file) = $app['util.repository']->extractRef($repository, $branch, $file);

            $type = $file ? "$branch -- \"$file\"" : $branch;
>>>>>>> 44ed193402c5a25cddbc80ef0c87183111f348b4
            $pager = $app['util.view']->getPager($app['request']->get('page'), $repository->getTotalCommits($type));
            $commits = $repository->getPaginatedCommits($type, $pager['current']);

            foreach ($commits as $commit) {
                $date = $commit->getDate();
                $date = $date->format('m/d/Y');
                $categorized[$date][] = $commit;
            }

            $template = $app['request']->isXmlHttpRequest() ? 'commits_list.twig' : 'commits.twig';

            return $app['twig']->render($template, array(
                'pager'          => $pager,
                'repo'           => $repo,
                'branch'         => $branch,
                'branches'       => $repository->getBranches(),
                'tags'           => $repository->getTags(),
                'commits'        => $categorized,
                'file'           => $file,
            ));
<<<<<<< HEAD
        })->assert('repo', '[\w-._]+')
          ->assert('branch', '[\w-._]+')
=======
        })->assert('repo', $app['util.routing']->getRepositoryRegex())
          ->assert('branch', '[\w-._\/]+')
>>>>>>> 44ed193402c5a25cddbc80ef0c87183111f348b4
          ->assert('file', '.+')
          ->value('branch', 'master')
          ->value('file', '')
          ->bind('commits');

        $route->post('{repo}/commits/search', function(Request $request, $repo) use ($app) {
            $repository = $app['git']->getRepository($app['git.repos'] . $repo);
            $commits = $repository->searchCommitLog($request->get('query'));

            foreach ($commits as $commit) {
                $date = $commit->getDate();
                $date = $date->format('m/d/Y');
                $categorized[$date][] = $commit;
            }

            return $app['twig']->render('searchcommits.twig', array(
                'repo'           => $repo,
                'branch'         => 'master',
                'file'           => '',
                'commits'        => $categorized,
                'branches'       => $repository->getBranches(),
                'tags'           => $repository->getTags(),
            ));
<<<<<<< HEAD
        })->assert('repo', '[\w-._]+')
=======
        })->assert('repo', $app['util.routing']->getRepositoryRegex())
>>>>>>> 44ed193402c5a25cddbc80ef0c87183111f348b4
          ->bind('searchcommits');

        $route->get('{repo}/commit/{commit}/', function($repo, $commit) use ($app) {
            $repository = $app['git']->getRepository($app['git.repos'] . $repo);
            $commit = $repository->getCommit($commit);

            return $app['twig']->render('commit.twig', array(
                'branch'         => 'master',
                'repo'           => $repo,
                'commit'         => $commit,
            ));
<<<<<<< HEAD
        })->assert('repo', '[\w-._]+')
=======
        })->assert('repo', $app['util.routing']->getRepositoryRegex())
>>>>>>> 44ed193402c5a25cddbc80ef0c87183111f348b4
          ->assert('commit', '[a-f0-9^]+')
          ->bind('commit');

        $route->get('{repo}/blame/{branch}/{file}', function($repo, $branch, $file) use ($app) {
            $repository = $app['git']->getRepository($app['git.repos'] . $repo);
<<<<<<< HEAD
            $blames = $repository->getBlame("$branch -- $file");
=======

            list($branch, $file) = $app['util.repository']->extractRef($repository, $branch, $file);

            $blames = $repository->getBlame("$branch -- \"$file\"");
>>>>>>> 44ed193402c5a25cddbc80ef0c87183111f348b4

            return $app['twig']->render('blame.twig', array(
                'file'           => $file,
                'repo'           => $repo,
                'branch'         => $branch,
                'branches'       => $repository->getBranches(),
                'tags'           => $repository->getTags(),
                'blames'         => $blames,
            ));
<<<<<<< HEAD
        })->assert('repo', '[\w-._]+')
          ->assert('file', '.+')
          ->assert('branch', '[\w-._]+')
=======
        })->assert('repo', $app['util.routing']->getRepositoryRegex())
          ->assert('file', '.+')
          ->assert('branch', '[\w-._\/]+')
>>>>>>> 44ed193402c5a25cddbc80ef0c87183111f348b4
          ->bind('blame');

        return $route;
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 44ed193402c5a25cddbc80ef0c87183111f348b4

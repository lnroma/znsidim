<?php

namespace App\Console\Commands;

use App\Models\Blogs;
use App\Models\Sphinx;
use App\User;
use Illuminate\Console\Command;
use Riari\Forum\Models\Post;
use sngrl\SphinxSearch\SphinxSearchServiceProvider;

class IndexSphinx extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sphinx:index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create sphinx index in database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $blogs = Blogs::all();

        $this->info('Delete all index');
        $indexes = Sphinx::all();

        foreach ($indexes as $_index) {
            $_index->delete();
        }
        $this->info('End delete all index');

        $this->info('Create blog index');
        $blogBar = $this->output->createProgressBar(count($blogs));
        foreach ($blogs as $_blog) {
            $sphinx = new Sphinx();
            $commonContent = $_blog->name . '  ' . $_blog->content;
            $sphinx->index = strip_tags($commonContent);
            $sphinx->sources_id = $_blog->id;
            $sphinx->module = Sphinx::INDEX_TYPE_BLOG;
            $sphinx->save();
            $blogBar->advance();
        }
        $blogBar->finish();
        $this->info('finish create blog index');

        $this->info('create user index');
        $user = User::all();
        $userBar = $this->output->createProgressBar(count($user));
        foreach ($user as $_user) {
            $sphinx = new Sphinx();
            $commonContent = $_user->name . ' ' . $_user->hello . ' ' . $_user->about_me;
            $sphinx->index = $commonContent;
            $sphinx->sources_id = $_user->id;
            $sphinx->module = Sphinx::INDEX_TYPE_USER;
            $sphinx->save();
            $userBar->advance();
        }
        $userBar->finish();
        $this->info('finish create user index');

        $this->info('create forum post index');
        $forumPosts = Post::all();
        $forumBar = $this->output->createProgressBar(count($forumPosts));
        foreach ($forumPosts as $_forumPost)
        {
            $sphinx = new Sphinx();
            $sphinx->index = $_forumPost->content;
            $sphinx->sources_id = $_forumPost->thread_id;
            $sphinx->module = Sphinx::INDEX_TYPE_FORUM;
            $sphinx->save();
            $forumBar->advance();
        }
        $forumBar->finish();
        $this->info('finish create user index');
        $this->info('ok all index has been reindex');
    }
}

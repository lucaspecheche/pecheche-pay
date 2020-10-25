<?php

namespace Transactions\Constants;

final class Status
{
    public const PENDING_SUBMISSION = 'PENDING_SUBMISSION';
    public const DEBITED            = 'DEBITED';
    public const CREDITED           = 'CREDITED';
    public const REFUNDED           = 'REFUNDED';
    public const COMPLETED          = 'COMPLETED';
    public const INCONSISTENT       = 'INCONSISTENT';
}
